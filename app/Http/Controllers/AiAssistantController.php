<?php

namespace App\Http\Controllers;

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
}
