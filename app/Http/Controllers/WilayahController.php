<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WilayahController extends Controller
{
    private $primaryBaseUrl = 'https://wilayah.id/api';

    /**
     * Helper to fetch JSON from Wilayah API with caching, timeout, and multiple fallbacks
     */
    private function fetchFromApi($endpoint, $cacheKey, $fallbackData = [])
    {
        // Check cache first
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && !empty($cached['data'])) {
                return $cached;
            }
        }

        $result = ['data' => []];

        // Tier 1: Try Primary API (wilayah.id)
        try {
            $url = "{$this->primaryBaseUrl}/{$endpoint}";
            $response = Http::withoutVerifying()
                ->timeout(4)
                ->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                    'Accept' => 'application/json',
                ])
                ->get($url);

            if ($response->successful()) {
                $json = $response->json();
                if (isset($json['data']) && count($json['data']) > 0) {
                    $result = $json;
                }
            }
        } catch (\Exception $e) {
            Log::warning("Wilayah.id primary API failed for {$endpoint}: " . $e->getMessage());
        }

        // Tier 2: Try curl if Http client failed or returned empty
        if (empty($result['data'])) {
            try {
                $url = "{$this->primaryBaseUrl}/{$endpoint}";
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 4);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)');
                $res = curl_exec($ch);
                curl_close($ch);

                if ($res) {
                    $json = json_decode($res, true);
                    if (is_array($json) && isset($json['data']) && count($json['data']) > 0) {
                        $result = $json;
                    }
                }
            } catch (\Exception $e) {
                Log::warning("Wilayah curl fallback failed for {$endpoint}: " . $e->getMessage());
            }
        }

        // Tier 3: If still empty, use Static Fallback Data
        if (empty($result['data']) && !empty($fallbackData)) {
            $result = [
                'data' => $fallbackData,
                'meta' => ['source' => 'local_fallback', 'total' => count($fallbackData)]
            ];
        }

        // Only cache if we have valid data
        if (!empty($result['data'])) {
            Cache::put($cacheKey, $result, 86400); // 24 hours
        }

        return $result;
    }

    /**
     * Fallback data: 38 Provinsi di Indonesia
     */
    private function getFallbackProvinces()
    {
        return [
            ['code' => '35', 'name' => 'JAWA TIMUR'],
            ['code' => '31', 'name' => 'DKI JAKARTA'],
            ['code' => '32', 'name' => 'JAWA BARAT'],
            ['code' => '33', 'name' => 'JAWA TENGAH'],
            ['code' => '34', 'name' => 'DAERAH ISTIMEWA YOGYAKARTA'],
            ['code' => '36', 'name' => 'BANTEN'],
            ['code' => '51', 'name' => 'BALI'],
            ['code' => '52', 'name' => 'NUSA TENGGARA BARAT'],
            ['code' => '53', 'name' => 'NUSA TENGGARA TIMUR'],
            ['code' => '11', 'name' => 'ACEH'],
            ['code' => '12', 'name' => 'SUMATERA UTARA'],
            ['code' => '13', 'name' => 'SUMATERA BARAT'],
            ['code' => '14', 'name' => 'RIAU'],
            ['code' => '15', 'name' => 'JAMBI'],
            ['code' => '16', 'name' => 'SUMATERA SELATAN'],
            ['code' => '17', 'name' => 'BENGKULU'],
            ['code' => '18', 'name' => 'LAMPUNG'],
            ['code' => '19', 'name' => 'KEPULAUAN BANGKA BELITUNG'],
            ['code' => '20', 'name' => 'KEPULAUAN RIAU'],
            ['code' => '61', 'name' => 'KALIMANTAN BARAT'],
            ['code' => '62', 'name' => 'KALIMANTAN TENGAH'],
            ['code' => '63', 'name' => 'KALIMANTAN SELATAN'],
            ['code' => '64', 'name' => 'KALIMANTAN TIMUR'],
            ['code' => '65', 'name' => 'KALIMANTAN UTARA'],
            ['code' => '71', 'name' => 'SULAWESI UTARA'],
            ['code' => '72', 'name' => 'SULAWESI TENGAH'],
            ['code' => '73', 'name' => 'SULAWESI SELATAN'],
            ['code' => '74', 'name' => 'SULAWESI TENGGARA'],
            ['code' => '75', 'name' => 'GORONTALO'],
            ['code' => '76', 'name' => 'SULAWESI BARAT'],
            ['code' => '81', 'name' => 'MALUKU'],
            ['code' => '82', 'name' => 'MALUKU UTARA'],
            ['code' => '91', 'name' => 'PAPUA BARAT'],
            ['code' => '92', 'name' => 'PAPUA'],
            ['code' => '93', 'name' => 'PAPUA SELATAN'],
            ['code' => '94', 'name' => 'PAPUA TENGAH'],
            ['code' => '95', 'name' => 'PAPUA PEGUNUNGAN'],
            ['code' => '96', 'name' => 'PAPUA BARAT DAYA'],
        ];
    }

    /**
     * Fallback data: 38 Kabupaten & Kota di Provinsi Jawa Timur (Kode 35)
     */
    private function getFallbackJatimRegencies()
    {
        return [
            ['code' => '35.01', 'province_code' => '35', 'name' => 'KABUPATEN PACITAN'],
            ['code' => '35.02', 'province_code' => '35', 'name' => 'KABUPATEN PONOROGO'],
            ['code' => '35.03', 'province_code' => '35', 'name' => 'KABUPATEN TRENGGALEK'],
            ['code' => '35.04', 'province_code' => '35', 'name' => 'KABUPATEN TULUNGAGUNG'],
            ['code' => '35.05', 'province_code' => '35', 'name' => 'KABUPATEN BLITAR'],
            ['code' => '35.06', 'province_code' => '35', 'name' => 'KABUPATEN KEDIRI'],
            ['code' => '35.07', 'province_code' => '35', 'name' => 'KABUPATEN MALANG'],
            ['code' => '35.08', 'province_code' => '35', 'name' => 'KABUPATEN LUMAJANG'],
            ['code' => '35.09', 'province_code' => '35', 'name' => 'KABUPATEN JEMBER'],
            ['code' => '35.10', 'province_code' => '35', 'name' => 'KABUPATEN BANYUWANGI'],
            ['code' => '35.11', 'province_code' => '35', 'name' => 'KABUPATEN BONDOWOSO'],
            ['code' => '35.12', 'province_code' => '35', 'name' => 'KABUPATEN SITUBONDO'],
            ['code' => '35.13', 'province_code' => '35', 'name' => 'KABUPATEN PROBOLINGGO'],
            ['code' => '35.14', 'province_code' => '35', 'name' => 'KABUPATEN PASURUAN'],
            ['code' => '35.15', 'province_code' => '35', 'name' => 'KABUPATEN SIDOARJO'],
            ['code' => '35.16', 'province_code' => '35', 'name' => 'KABUPATEN MOJOKERTO'],
            ['code' => '35.17', 'province_code' => '35', 'name' => 'KABUPATEN JOMBANG'],
            ['code' => '35.18', 'province_code' => '35', 'name' => 'KABUPATEN NGANJUK'],
            ['code' => '35.19', 'province_code' => '35', 'name' => 'KABUPATEN MADIUN'],
            ['code' => '35.20', 'province_code' => '35', 'name' => 'KABUPATEN MAGETAN'],
            ['code' => '35.21', 'province_code' => '35', 'name' => 'KABUPATEN NGAWI'],
            ['code' => '35.22', 'province_code' => '35', 'name' => 'KABUPATEN BOJONEGORO'],
            ['code' => '35.23', 'province_code' => '35', 'name' => 'KABUPATEN TUBAN'],
            ['code' => '35.24', 'province_code' => '35', 'name' => 'KABUPATEN LAMONGAN'],
            ['code' => '35.25', 'province_code' => '35', 'name' => 'KABUPATEN GRESIK'],
            ['code' => '35.26', 'province_code' => '35', 'name' => 'KABUPATEN BANGKALAN'],
            ['code' => '35.27', 'province_code' => '35', 'name' => 'KABUPATEN SAMPANG'],
            ['code' => '35.28', 'province_code' => '35', 'name' => 'KABUPATEN PAMEKASAN'],
            ['code' => '35.29', 'province_code' => '35', 'name' => 'KABUPATEN SUMENEP'],
            ['code' => '35.71', 'province_code' => '35', 'name' => 'KOTA KEDIRI'],
            ['code' => '35.72', 'province_code' => '35', 'name' => 'KOTA BLITAR'],
            ['code' => '35.73', 'province_code' => '35', 'name' => 'KOTA MALANG'],
            ['code' => '35.74', 'province_code' => '35', 'name' => 'KOTA PROBOLINGGO'],
            ['code' => '35.75', 'province_code' => '35', 'name' => 'KOTA PASURUAN'],
            ['code' => '35.76', 'province_code' => '35', 'name' => 'KOTA MOJOKERTO'],
            ['code' => '35.77', 'province_code' => '35', 'name' => 'KOTA MADIUN'],
            ['code' => '35.78', 'province_code' => '35', 'name' => 'KOTA SURABAYA'],
            ['code' => '35.79', 'province_code' => '35', 'name' => 'KOTA BATU'],
        ];
    }

    public function provinces()
    {
        $data = $this->fetchFromApi('provinces.json', 'wilayah_provinces', $this->getFallbackProvinces());
        return response()->json($data)->header('Access-Control-Allow-Origin', '*');
    }

    public function regencies($provCode)
    {
        $fallback = ($provCode == '35') ? $this->getFallbackJatimRegencies() : [];
        $data = $this->fetchFromApi("regencies/{$provCode}.json", "wilayah_regencies_{$provCode}", $fallback);
        return response()->json($data)->header('Access-Control-Allow-Origin', '*');
    }

    public function districts($regCode)
    {
        $data = $this->fetchFromApi("districts/{$regCode}.json", "wilayah_districts_{$regCode}");
        return response()->json($data)->header('Access-Control-Allow-Origin', '*');
    }

    public function villages($distCode)
    {
        $data = $this->fetchFromApi("villages/{$distCode}.json", "wilayah_villages_{$distCode}");
        return response()->json($data)->header('Access-Control-Allow-Origin', '*');
    }
}

