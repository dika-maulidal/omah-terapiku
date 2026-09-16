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
     * Helper to fetch JSON from Wilayah API with caching, fast IPv4 curl, timeout, and fallbacks
     */
    private function fetchFromApi($endpoint, $cacheKey, $fallbackData = [])
    {
        // Check cache first (cached for 7 days because wilayah data is static)
        if (Cache::has($cacheKey)) {
            $cached = Cache::get($cacheKey);
            if (is_array($cached) && !empty($cached['data'])) {
                return $cached;
            }
        }

        $result = ['data' => []];
        $url = "{$this->primaryBaseUrl}/{$endpoint}";

        // Tier 1: Fast Native cURL with IPv4 forced
        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_TIMEOUT, 8);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Accept: application/json',
            ]);
            $res = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($res && $httpCode === 200) {
                $json = json_decode($res, true);
                if (is_array($json) && isset($json['data']) && count($json['data']) > 0) {
                    $result = $json;
                }
            }
        } catch (\Exception $e) {
            Log::warning("Wilayah cURL primary fetch failed for {$endpoint}: " . $e->getMessage());
        }

        // Tier 2: Laravel Http Client with IPv4 options
        if (empty($result['data'])) {
            try {
                $response = Http::withoutVerifying()
                    ->withOptions([
                        'curl' => [
                            CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4,
                            CURLOPT_CONNECTTIMEOUT => 4,
                        ]
                    ])
                    ->timeout(8)
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
                Log::warning("Wilayah Http fallback failed for {$endpoint}: " . $e->getMessage());
            }
        }

        // Tier 3: If still empty, use Static Fallback Data
        if (empty($result['data']) && !empty($fallbackData)) {
            $result = [
                'data' => $fallbackData,
                'meta' => ['source' => 'local_fallback', 'total' => count($fallbackData)]
            ];
        }

        // Cache valid data for 7 days
        if (!empty($result['data'])) {
            Cache::put($cacheKey, $result, 604800);
        }

        return $result;
    }

    /**
     * Fallback data: 38 Provinsi di Indonesia
     */
    private function getFallbackProvinces()
    {
        return [
            ['code' => '11', 'name' => 'Aceh'],
            ['code' => '12', 'name' => 'Sumatera Utara'],
            ['code' => '13', 'name' => 'Sumatera Barat'],
            ['code' => '14', 'name' => 'Riau'],
            ['code' => '15', 'name' => 'Jambi'],
            ['code' => '16', 'name' => 'Sumatera Selatan'],
            ['code' => '17', 'name' => 'Bengkulu'],
            ['code' => '18', 'name' => 'Lampung'],
            ['code' => '19', 'name' => 'Kepulauan Bangka Belitung'],
            ['code' => '21', 'name' => 'Kepulauan Riau'],
            ['code' => '31', 'name' => 'DKI Jakarta'],
            ['code' => '32', 'name' => 'Jawa Barat'],
            ['code' => '33', 'name' => 'Jawa Tengah'],
            ['code' => '34', 'name' => 'Daerah Istimewa Yogyakarta'],
            ['code' => '35', 'name' => 'Jawa Timur'],
            ['code' => '36', 'name' => 'Banten'],
            ['code' => '51', 'name' => 'Bali'],
            ['code' => '52', 'name' => 'Nusa Tenggara Barat'],
            ['code' => '53', 'name' => 'Nusa Tenggara Timur'],
            ['code' => '61', 'name' => 'Kalimantan Barat'],
            ['code' => '62', 'name' => 'Kalimantan Tengah'],
            ['code' => '63', 'name' => 'Kalimantan Selatan'],
            ['code' => '64', 'name' => 'Kalimantan Timur'],
            ['code' => '65', 'name' => 'Kalimantan Utara'],
            ['code' => '71', 'name' => 'Sulawesi Utara'],
            ['code' => '72', 'name' => 'Sulawesi Tengah'],
            ['code' => '73', 'name' => 'Sulawesi Selatan'],
            ['code' => '74', 'name' => 'Sulawesi Tenggara'],
            ['code' => '75', 'name' => 'Gorontalo'],
            ['code' => '76', 'name' => 'Sulawesi Barat'],
            ['code' => '81', 'name' => 'Maluku'],
            ['code' => '82', 'name' => 'Maluku Utara'],
            ['code' => '91', 'name' => 'Papua'],
            ['code' => '92', 'name' => 'Papua Barat'],
            ['code' => '93', 'name' => 'Papua Selatan'],
            ['code' => '94', 'name' => 'Papua Tengah'],
            ['code' => '95', 'name' => 'Papua Pegunungan'],
            ['code' => '96', 'name' => 'Papua Barat Daya'],
        ];
    }

    /**
     * Fallback data: 38 Kabupaten & Kota di Provinsi Jawa Timur (Kode 35)
     */
    private function getFallbackJatimRegencies()
    {
        return [
            ['code' => '35.01', 'province_code' => '35', 'name' => 'Kabupaten Pacitan'],
            ['code' => '35.02', 'province_code' => '35', 'name' => 'Kabupaten Ponorogo'],
            ['code' => '35.03', 'province_code' => '35', 'name' => 'Kabupaten Trenggalek'],
            ['code' => '35.04', 'province_code' => '35', 'name' => 'Kabupaten Tulungagung'],
            ['code' => '35.05', 'province_code' => '35', 'name' => 'Kabupaten Blitar'],
            ['code' => '35.06', 'province_code' => '35', 'name' => 'Kabupaten Kediri'],
            ['code' => '35.07', 'province_code' => '35', 'name' => 'Kabupaten Malang'],
            ['code' => '35.08', 'province_code' => '35', 'name' => 'Kabupaten Lumajang'],
            ['code' => '35.09', 'province_code' => '35', 'name' => 'Kabupaten Jember'],
            ['code' => '35.10', 'province_code' => '35', 'name' => 'Kabupaten Banyuwangi'],
            ['code' => '35.11', 'province_code' => '35', 'name' => 'Kabupaten Bondowoso'],
            ['code' => '35.12', 'province_code' => '35', 'name' => 'Kabupaten Situbondo'],
            ['code' => '35.13', 'province_code' => '35', 'name' => 'Kabupaten Probolinggo'],
            ['code' => '35.14', 'province_code' => '35', 'name' => 'Kabupaten Pasuruan'],
            ['code' => '35.15', 'province_code' => '35', 'name' => 'Kabupaten Sidoarjo'],
            ['code' => '35.16', 'province_code' => '35', 'name' => 'Kabupaten Mojokerto'],
            ['code' => '35.17', 'province_code' => '35', 'name' => 'Kabupaten Jombang'],
            ['code' => '35.18', 'province_code' => '35', 'name' => 'Kabupaten Nganjuk'],
            ['code' => '35.19', 'province_code' => '35', 'name' => 'Kabupaten Madiun'],
            ['code' => '35.20', 'province_code' => '35', 'name' => 'Kabupaten Magetan'],
            ['code' => '35.21', 'province_code' => '35', 'name' => 'Kabupaten Ngawi'],
            ['code' => '35.22', 'province_code' => '35', 'name' => 'Kabupaten Bojonegoro'],
            ['code' => '35.23', 'province_code' => '35', 'name' => 'Kabupaten Tuban'],
            ['code' => '35.24', 'province_code' => '35', 'name' => 'Kabupaten Lamongan'],
            ['code' => '35.25', 'province_code' => '35', 'name' => 'Kabupaten Gresik'],
            ['code' => '35.26', 'province_code' => '35', 'name' => 'Kabupaten Bangkalan'],
            ['code' => '35.27', 'province_code' => '35', 'name' => 'Kabupaten Sampang'],
            ['code' => '35.28', 'province_code' => '35', 'name' => 'Kabupaten Pamekasan'],
            ['code' => '35.29', 'province_code' => '35', 'name' => 'Kabupaten Sumenep'],
            ['code' => '35.71', 'province_code' => '35', 'name' => 'Kota Kediri'],
            ['code' => '35.72', 'province_code' => '35', 'name' => 'Kota Blitar'],
            ['code' => '35.73', 'province_code' => '35', 'name' => 'Kota Malang'],
            ['code' => '35.74', 'province_code' => '35', 'name' => 'Kota Probolinggo'],
            ['code' => '35.75', 'province_code' => '35', 'name' => 'Kota Pasuruan'],
            ['code' => '35.76', 'province_code' => '35', 'name' => 'Kota Mojokerto'],
            ['code' => '35.77', 'province_code' => '35', 'name' => 'Kota Madiun'],
            ['code' => '35.78', 'province_code' => '35', 'name' => 'Kota Surabaya'],
            ['code' => '35.79', 'province_code' => '35', 'name' => 'Kota Batu'],
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
