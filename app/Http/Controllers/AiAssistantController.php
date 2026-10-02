<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Rekam;
use App\Models\RekamDiagnosa;
use App\Models\RekamAssessment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiAssistantController extends Controller
{
    private $systemPrompt = <<<PROMPT
Anda adalah AI Asisten Klinis & Terapi Terpadu di Omah Terapi-KU (Pusat Layanan Disabilitas & Terapi Terpadu Dinas Sosial Provinsi Jawa Timur).
Peran Anda adalah menjadi rekan asisten cerdas bagi para Terapis (Fisioterapis, Terapis Okupasi, Terapis Wicara, Sensori Integrasi), Dokter, Petugas Medis, dan Orang Tua/Wali Penerima Manfaat.

KOMPETENSI & CAKUPAN TUGAS UTAMA:
1. Rekomendasi Rencana Intervensi & Tindakan Klinis: Fisioterapi Pediatrik, Terapi Okupasi (Sensori Integrasi, Motorik Halus, Kognitif, ADL), dan Terapi Wicara/Bahasa.
2. Ragam Disabilitas & Hambatan Tumbuh Kembang: Cerebral Palsy (Spastik, Atetoid, Ataksik), ASD/Autisme, ADHD, Down Syndrome, Global Developmental Delay (GDD), Speech Delay, Sensory Processing Disorder (SPD), Microcephaly/Hydrocephalus, Tuna Daksa, Tuna Grahita, dll.
3. Penyusunan Program Latihan Rumahan (Home Program): Memberikan instruksi latihan mandiri yang ramah keluarga, aman, praktis, dan dapat diaplikasikan di rumah oleh orang tua/wali.
4. Analisis Asesmen & Diagnosa Fungsional: Membantu merumuskan diagnosa fungsional, analisis gerak/postur, respon sensori (hiperaktif/hiporeaktif), dan pemantauan capaian 15 modul asesmen.

GAYA KOMUNIKASI & FORMAT JAWABAN (SANGAT PENTING):
- LANGSUNG ke inti jawaban secara terstruktur, to-the-point, dan actionable.
- Hindari pembukaan atau basa-basi berlebihan. Segera berikan poin-poin langkah terapi yang konkret.
- Gunakan Markdown yang rapi: judul bagian (**###**), poin-poin (**-** atau **1.**), teks tebal (**bold**) untuk kata kunci penting.
- Pastikan jawaban TUNTAS, lengkap dari awal hingga akhir, dan tidak terputus di tengah kalimat.

ATURAN KETAT & GUARDRAILS:
- HANYA jawab pertanyaan seputar medis, terapi fisik/okupasi/wicara, sensori integrasi, disabilitas, tumbuh kembang anak, dan rehabilitasi sosial-medis.
- JIKA pengguna menanyakan hal di luar konteks tersebut (misalnya politik, coding/pemrograman umum, gosip, resep makanan umum, olahraga di luar terapi, dll), TOLAK DENGAN RAMAH:
  "Mohon maaf, saya adalah AI Asisten Klinis & Terapi khusus Omah Terapi-KU. Saya hanya dapat membantu konsultasi seputar layanan terapi (Fisioterapi, Okupasi, Wicara, Sensori Integrasi), tumbuh kembang disabilitas anak, rekomendasi intervensi klinis, dan ide latihan rumahan (Home Program). Silakan ajukan pertanyaan seputar bidang tersebut."
PROMPT;

    public function chat(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:2000',
            'history' => 'nullable|array',
            'history.*.role' => 'required_with:history|string|in:user,model,assistant',
            'history.*.parts' => 'required_with:history|array',
        ]);

        $apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-3.7-flash'));

        if (empty($apiKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Konfigurasi Gemini API Key belum terpasang di sistem.'
            ], 500);
        }

        // Format riwayat percakapan untuk Gemini API
        $contents = [];
        if ($request->has('history') && is_array($request->history)) {
            foreach ($request->history as $item) {
                $role = ($item['role'] === 'assistant' || $item['role'] === 'model') ? 'model' : 'user';
                $text = '';
                if (isset($item['parts'][0]['text'])) {
                    $text = $item['parts'][0]['text'];
                } elseif (isset($item['content'])) {
                    $text = $item['content'];
                }

                if (!empty($text)) {
                    $contents[] = [
                        'role' => $role,
                        'parts' => [
                            ['text' => $text]
                        ]
                    ];
                }
            }
        }

        // Tambahkan prompt saat ini
        $contents[] = [
            'role' => 'user',
            'parts' => [
                ['text' => $request->prompt]
            ]
        ];

        // URL Endpoint Gemini API
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $this->systemPrompt]
                ]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.35,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 8192,
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->timeout(45)
            ->withoutVerifying()
            ->post($url, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, tidak ada respon yang dapat dihasilkan saat ini.';

                return response()->json([
                    'success' => true,
                    'reply' => $reply,
                    'model' => $model
                ]);
            } else {
                Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
                
                // Fallback attempt dengan model gemini-3.5-flash jika model default mengalami masalah
                if ($model !== 'gemini-3.5-flash') {
                    $fallbackUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent?key={$apiKey}";
                    $fallbackRes = Http::withHeaders(['Content-Type' => 'application/json'])
                        ->timeout(45)
                        ->withoutVerifying()
                        ->post($fallbackUrl, $payload);

                    if ($fallbackRes->successful()) {
                        $fallbackData = $fallbackRes->json();
                        $reply = $fallbackData['candidates'][0]['content']['parts'][0]['text'] ?? 'Respon diterima.';
                        return response()->json([
                            'success' => true,
                            'reply' => $reply,
                            'model' => 'gemini-3.5-flash'
                        ]);
                    }
                }

                $errBody = $response->json();
                $errMsg = $errBody['error']['message'] ?? 'Terjadi kesalahan saat menghubungi layanan AI Gemini.';

                return response()->json([
                    'success' => false,
                    'message' => 'Layanan AI mengalami kendala: ' . $errMsg
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Exception in AiAssistantController: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal terhubung ke AI: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate Saran Rekomendasi Tindakan & Home Program Otomatis berbasis Asesmen & Diagnosa Pasien
     */
    public function suggestPlan(Request $request)
    {
        $pasienId = $request->input('pasien_id');
        $rekamId = $request->input('rekam_id');

        $rekam = null;
        if (!empty($rekamId) && (int)$rekamId > 0) {
            $rekam = Rekam::with(['assessment', 'pasien'])->find($rekamId);
            if ($rekam && !$pasienId) {
                $pasienId = $rekam->pasien_id;
            }
        }

        $pasien = $pasienId ? Pasien::find($pasienId) : ($rekam ? $rekam->pasien : null);
        if (!$pasien && $rekam) {
            $pasien = $rekam->pasien;
        }

        if (!$pasien) {
            return response()->json([
                'success' => false,
                'message' => 'Data penerima manfaat tidak ditemukan.'
            ], 404);
        }

        // Ambil assessment dari rekam medis terkait atau assessment terakhir pasien
        $assessment = null;
        if ($rekam && $rekam->assessment) {
            $assessment = $rekam->assessment;
        } else {
            $assessment = RekamAssessment::where('pasien_id', $pasien->id)->latest('tgl_assessment')->first();
        }

        // Diagnosa ICD-10 & Diagnosa Klinis
        $diagnosaList = [];
        if ($rekam) {
            $diagRecords = RekamDiagnosa::with('diagnosis')->where('rekam_id', $rekam->id)->get();
            foreach ($diagRecords as $d) {
                if ($d->diagnosis) {
                    $diagName = $d->diagnosis->name_id ?: $d->diagnosis->name_en;
                    $diagnosaList[] = "{$d->diagnosa} - {$diagName}";
                } elseif (!empty($d->diagnosa)) {
                    $diagnosaList[] = $d->diagnosa;
                }
            }
            if (!empty($rekam->diagnosa)) {
                $diagnosaList[] = $rekam->diagnosa;
            }
        }
        $diagnosaStr = !empty($diagnosaList) ? implode(', ', array_unique($diagnosaList)) : 'Belum tercatat spesifik';

        // Hitung Usia & Kategori Pasien
        $usiaStr = '-';
        $isPediatrik = true;
        if ($pasien->tgl_lahir) {
            $birthDate = Carbon::parse($pasien->tgl_lahir);
            $ageYears = $birthDate->age;
            $ageMonths = $birthDate->diffInMonths(Carbon::now());
            if ($ageYears < 2) {
                $usiaStr = "{$ageMonths} Bulan";
                $isPediatrik = true;
            } else {
                $usiaStr = "{$ageYears} Tahun";
                $isPediatrik = ($ageYears < 18);
            }
        }
        $kategoriUsia = $isPediatrik ? 'Pediatrik / Anak' : 'Dewasa';
        $jenisDisabilitas = $pasien->jenis_disabilitas ?: 'Tidak ada catatan disabilitas khusus';
        $alatBantu = $pasien->alat_bantu ?: 'Tidak ada';
        $layananTerapi = ($rekam && $rekam->layanan_terapi) ? $rekam->layanan_terapi : (($rekam && $rekam->poli) ? $rekam->poli : 'Fisioterapi & Terapi Terpadu');
        $keluhan = ($rekam && $rekam->keluhan) ? $rekam->keluhan : 'Evaluasi dan intervensi lanjutan';

        // Ekstraksi temuan dari 15 modul asesmen klinis
        $motorikNotes = [];
        if ($assessment) {
            if ($assessment->motorik_mengangkat_kepala) $motorikNotes[] = "Mengangkat Kepala: {$assessment->motorik_mengangkat_kepala}";
            if ($assessment->motorik_posisi_tengkurap) $motorikNotes[] = "Posisi Tengkurap: {$assessment->motorik_posisi_tengkurap}";
            if ($assessment->motorik_posisi_duduk) $motorikNotes[] = "Posisi Duduk: {$assessment->motorik_posisi_duduk}";
            if ($assessment->motorik_merangkak) $motorikNotes[] = "Merangkak: {$assessment->motorik_merangkak}";
            if ($assessment->motorik_berlutut) $motorikNotes[] = "Berlutut: {$assessment->motorik_berlutut}";
            if ($assessment->motorik_berjalan) $motorikNotes[] = "Berjalan: {$assessment->motorik_berjalan}";
            if ($assessment->gmfm_total_score) $motorikNotes[] = "GMFM Total Score: {$assessment->gmfm_total_score}%";
        }
        $motorikStr = !empty($motorikNotes) ? implode('; ', $motorikNotes) : '-';

        $romMmtStr = '-';
        if ($assessment && !empty($assessment->rom_mmt_data)) {
            $romMmtStr = is_array($assessment->rom_mmt_data) ? json_encode($assessment->rom_mmt_data, JSON_UNESCAPED_UNICODE) : (string)$assessment->rom_mmt_data;
        }

        $nyeriStr = ($assessment && $assessment->nyeri_skor !== null) ? "Skor {$assessment->nyeri_skor}/10 (Lokasi: " . ($assessment->nyeri_lokasi ?: '-') . ")" : '-';
        $posturStr = ($assessment && !empty($assessment->postur_temuan)) ? (is_array($assessment->postur_temuan) ? implode(', ', $assessment->postur_temuan) : (string)$assessment->postur_temuan) : '-';

        $adlNotes = [];
        if ($assessment) {
            if ($assessment->adl_makan) $adlNotes[] = "Makan: {$assessment->adl_makan}";
            if ($assessment->adl_berpakaian) $adlNotes[] = "Berpakaian: {$assessment->adl_berpakaian}";
            if ($assessment->adl_mandi) $adlNotes[] = "Mandi: {$assessment->adl_mandi}";
            if ($assessment->adl_duduk_tenang) $adlNotes[] = "Duduk Tenang: {$assessment->adl_duduk_tenang}";
            if ($assessment->adl_kontak_mata) $adlNotes[] = "Kontak Mata: {$assessment->adl_kontak_mata}";
        }
        $adlStr = !empty($adlNotes) ? implode('; ', $adlNotes) : '-';

        $wicaraStr = ($assessment && ($assessment->wicara_komunikasi || $assessment->wicara_organ || $assessment->wicara_makan_menelan)) ? "Komunikasi: {$assessment->wicara_komunikasi}, Organ: {$assessment->wicara_organ}, Menelan: {$assessment->wicara_makan_menelan}" : '-';
        $sensorisStr = ($assessment && ($assessment->sensoris_taktil_raba_halus || $assessment->sensoris_posisi_sendi || $assessment->vestibular_hit)) ? "Taktil: {$assessment->sensoris_taktil_raba_halus}, Proprioseptif: {$assessment->sensoris_posisi_sendi}, Vestibular: {$assessment->vestibular_hit}" : '-';

        $type = $request->input('type', 'all'); // 'tindakan', 'home_program', or 'all'

        $pasienNama = $pasien->nama;
        $jkStr = ($pasien->jk === 'L' || $pasien->jk === 'Laki-laki') ? 'Laki-laki' : 'Perempuan';

        $apiKey = config('services.gemini.api_key', env('GEMINI_API_KEY'));
        $model = config('services.gemini.model', env('GEMINI_MODEL', 'gemini-3.7-flash'));

        if (!empty($apiKey)) {
            $fokusInstruksi = "Susun rekomendasi intervensi klinis di klinik (Tindakan) dan panduan latihan mandiri di rumah (Home Program).";
            if ($type === 'tindakan') {
                $fokusInstruksi = "FOKUS UTAMA: Susun rekomendasi detail rencana tindakan dan intervensi klinis di sesi terapi klinik (modalitas fisik/manipulasi/latihan fungsional/stimulasi sensori/wicara).";
            } elseif ($type === 'home_program') {
                $fokusInstruksi = "FOKUS UTAMA: Susun rekomendasi detail panduan program latihan rumahan (Home Program) & edukasi keluarga yang praktis dan terukur untuk orang tua/wali.";
            }

            $prompt = <<<PROMPT
Anda adalah Konsultan Rehabilitasi Medis & Terapi Klinis Senior di Omah Terapi-KU (Dinas Sosial Provinsi Jawa Timur).
Tugas Anda: {$fokusInstruksi}

PROFIL PASIEN:
- Nama: {$pasienNama} ({$jkStr})
- Usia: {$usiaStr} ({$kategoriUsia})
- Ragam Disabilitas: {$jenisDisabilitas}
- Alat Bantu: {$alatBantu}
- Disiplin Layanan: {$layananTerapi}
- Keluhan Utama Sesi Ini: {$keluhan}
- Diagnosa Medis / ICD: {$diagnosaStr}

TEMUAN 15 MODUL ASESMEN KLINIS:
- Kemampuan Motorik Kasar & Gerak Fungsional: {$motorikStr}
- ROM & Kekuatan Otot (MMT): {$romMmtStr}
- Evaluasi Nyeri & Postur: Nyeri: {$nyeriStr} | Postur: {$posturStr}
- Kemandirian Aktivitas Sehari-hari (ADL): {$adlStr}
- Evaluasi Wicara, Sensori & Neuro: Wicara: {$wicaraStr} | Sensoris: {$sensorisStr}

FORMAT KELUARAN (WAJIB JSON VALID):
Berikan respon HANYA dalam format JSON valid tanpa format markdown codeblock ```json, dengan format:
{
    "tindakan": "Poin-poin langkah intervensi tindakan terapi terstruktur di klinik (gunakan bullet point '-' dan sebutkan modalitas, teknik manipulasi fisik/sensori/wicara, latihan gerak fungsional, dosis/repetisi)",
    "latihan_rumahan": "Poin-poin panduan latihan mandiri di rumah (Home Program) untuk orang tua/keluarga (bahasa ramah keluarga, instruksi konkret frekuensi/durasi, posisi yang benar, stimulasi harian)"
}
PROMPT;

            $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
            $payload = [
                'system_instruction' => [
                    'parts' => [
                        ['text' => 'Anda adalah sistem rekomendasi rencana tindakan terapi klinis dan home program berbasis data asesmen. Kembalikan HANYA JSON valid.']
                    ]
                ],
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [['text' => $prompt]]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.25,
                    'topK' => 30,
                    'topP' => 0.9,
                    'maxOutputTokens' => 4096,
                    'responseMimeType' => 'application/json'
                ]
            ];

            try {
                $response = Http::withHeaders(['Content-Type' => 'application/json'])
                    ->timeout(35)
                    ->withoutVerifying()
                    ->post($url, $payload);

                if ($response->successful()) {
                    $jsonRes = $response->json();
                    $rawText = $jsonRes['candidates'][0]['content']['parts'][0]['text'] ?? '';
                    
                    // Bersihkan pembungkus markdown jika ada
                    $cleanJson = preg_replace('/^```(?:json)?\s*/i', '', trim($rawText));
                    $cleanJson = preg_replace('/\s*```$/i', '', $cleanJson);

                    $parsed = json_decode($cleanJson, true);
                    if (is_array($parsed) && !empty($parsed['tindakan'])) {
                        return response()->json([
                            'success' => true,
                            'source' => 'gemini-ai',
                            'tindakan' => trim($parsed['tindakan']),
                            'latihan_rumahan' => trim($parsed['latihan_rumahan'] ?? '')
                        ]);
                    }
                } else {
                    Log::warning('Gemini suggestPlan API error: ' . $response->status() . ' - ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::warning('Gemini suggestPlan Exception: ' . $e->getMessage());
            }
        }

        // Intelligent Clinical Fallback Engine (jika API Key belum terpasang atau sedang offline)
        $fallback = $this->generateClinicalFallbackPlan($layananTerapi, $kategoriUsia, $jenisDisabilitas, $keluhan, $assessment);

        return response()->json([
            'success' => true,
            'source' => 'clinical-engine',
            'tindakan' => $fallback['tindakan'],
            'latihan_rumahan' => $fallback['latihan_rumahan']
        ]);
    }

    /**
     * Fallback Engine Klinis Berdasarkan Disiplin Layanan Terapi & Karakteristik Pasien
     */
    private function generateClinicalFallbackPlan($layanan, $kategoriUsia, $disabilitas, $keluhan, $assessment)
    {
        $layananLower = strtolower($layanan);
        $isAnak = strtolower($kategoriUsia) === 'pediatrik / anak' || str_contains(strtolower($disabilitas), 'cp') || str_contains(strtolower($disabilitas), 'cerebral') || str_contains(strtolower($disabilitas), 'gdd') || str_contains(strtolower($disabilitas), 'down');

        if (str_contains($layananLower, 'fisio')) {
            if ($isAnak) {
                return [
                    'tindakan' => "- Passive stretching otot ekstremitas bawah (hamstring, gastrocnemius, adductor) perlahan 3x10 repetisi untuk cegah kontraktur.\n- Fasilitasi kontrol kepala & batang tubuh (head & trunk control) di atas gymnastic ball.\n- Stimulasi transisi posisi (tengkurap -> duduk -> kneeling -> standing) dengan stimulasi taktil proprioseptif.\n- Latihan weight bearing ekstremitas bawah pada parallel bar / sensory stepping stone untuk fasilitasi pola jalan.",
                    'latihan_rumahan' => "- Lakukan peregangan lembut pada kedua tungkai kaki anak 2 kali sehari (pagi dan sore) saat posisi berbaring relaks.\n- Posisikan anak duduk tegak di kursi dengan kedua telapak kaki menapak lantai secara rata (hindari duduk posisi 'W').\n- Latih anak meraih mainan favorit dari posisi duduk ke berdiri dengan pengawasan orang tua 10-15 menit setiap hari."
                ];
            } else {
                return [
                    'tindakan' => "- Aplikasi modalitas fisik (Infrared / TENS) pada area keluhan selama 15 menit untuk relaksasi otot dan peredaran darah.\n- Mobilisasi sendi aktif & pasif (ROM exercise) untuk meningkatkan mobilitas sendi fungsional.\n- Latihan penguatan otot (strengthening exercise) menggunakan resistance band dan latihan stabilitas inti (core stability).\n- Koreksi postur dan latihan pola jalan (gait retraining) dengan alat bantu bila diperlukan.",
                    'latihan_rumahan' => "- Kompres hangat pada area yang kaku selama 15 menit sebelum melakukan latihan peregangan mandiri di rumah.\n- Lakukan peregangan mandiri sesuai instruksi terapis 2x sehari (10 repetisi per gerakan).\n- Perhatikan ergonomi postur saat duduk bekerja, berdiri, dan hindari mengangkat beban berlebih."
                ];
            }
        } elseif (str_contains($layananLower, 'okupasi') || str_contains($layananLower, 'sensori')) {
            return [
                'tindakan' => "- Stimulasi sensori integrasi: modulasi vestibular dan proprioseptif menggunakan ayunan terapi dan trampolin.\n- Latihan motorik halus (fine motor skills): stimulasi pincer grasp, meronce balok kayu, dan manipulasi plastisin/terapi clay.\n- Pelatihan koordinasi bilateral dan integrasi visual-motorik (eye-hand coordination).\n- Latihan kemandirian Activity of Daily Living (ADL): simulasi makan mandiri menggunakan sendok dan memasang kancing baju.",
                'latihan_rumahan' => "- Sediakan sensory bin sederhana di rumah (wadah berisi beras/kacang-kacangan) untuk eksplorasi sentuhan tangan ananda 10-15 menit per hari.\n- Libatkan ananda dalam aktivitas harian di rumah seperti memakai kaos dan melepas sepatu secara mandiri bertahap.\n- Buat rutinitas harian bergambar yang konsisten untuk membantu ananda lebih fokus dan tenang dalam transisi aktivitas."
            ];
        } elseif (str_contains($layananLower, 'wicara')) {
            return [
                'tindakan' => "- Oral motor stimulation & exercise: stimulasi taktil dan latihan penguatan otot bibir, lidah, dan pipi untuk kontrol artikulasi.\n- Stimulasi bahasa reseptif dan ekspresif menggunakan teknik naming, imitation, dan interactive flashcards.\n- Latihan fonasi dan artikulasi fonem sasaran secara bertahap.\n- Pengenalan sarana komunikasi alternatif / AAC sederhana bila diperlukan untuk memfasilitasi komunikasi dua arah.",
                'latihan_rumahan' => "- Ajak ananda berbicara tatap muka setinggi mata (eye-level) dengan kontak mata langsung saat berkomunikasi di rumah.\n- Batasi screen time (HP/TV) dan tingkatkan interaksi verbal langsung melalui membaca buku cerita bergambar bersama.\n- Berikan jeda waktu 5–10 detik bagi ananda untuk merespon pertanyaan sebelum memberikan bantuan kata."
            ];
        } else {
            return [
                'tindakan' => "- Latihan Orientasi & Mobilitas (O&M): pengenalan rute ruangan dan teknik trailing dinding secara mandiri.\n- Latihan pemanfaatan sensori pengganti (auditori dan taktil) untuk keselamatan bernavigasi.\n- Pelatihan penggunaan tongkat pemandu pada berbagai jenis permukaan lantai.\n- Latihan adaptasi kemandirian aktivitas fungsional harian di lingkungan sekitar.",
                'latihan_rumahan' => "- Pastikan penataan perabotan di rumah konsisten dan jalur jalan bebas dari halangan kabel atau benda licin.\n- Berikan penanda taktil/tekstur pada barang-barang pribadi anak di rumah untuk memudahkan identifikasi mandiri.\n- Dampingi anak berlatih rute mandiri di sekitar rumah secara konsisten dan beri apresiasi positif."
            ];
        }
    }
}

