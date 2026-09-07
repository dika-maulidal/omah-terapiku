<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WilayahController extends Controller
{
    private $baseUrl = 'https://wilayah.id/api';

    /**
     * Helper to fetch JSON from Wilayah.id with caching and SSL fallback
     */
    private function fetchFromApi($endpoint, $cacheKey)
    {
        return Cache::remember($cacheKey, 86400, function () use ($endpoint) {
            try {
                $url = "{$this->baseUrl}/{$endpoint}";
                $response = Http::withoutVerifying()
                    ->timeout(10)
                    ->withHeaders([
                        'User-Agent' => 'OmahTerapiku/1.0',
                        'Accept' => 'application/json',
                    ])
                    ->get($url);

                if ($response->successful()) {
                    return $response->json();
                }

                // Fallback using curl if Http client failed
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                $result = curl_exec($ch);
                curl_close($ch);

                if ($result) {
                    $json = json_decode($result, true);
                    if (is_array($json)) {
                        return $json;
                    }
                }

                return ['data' => [], 'meta' => ['error' => 'HTTP ' . $response->status()]];
            } catch (\Exception $e) {
                Log::error("Wilayah.id API fetch error for {$endpoint}: " . $e->getMessage());
                return ['data' => [], 'meta' => ['error' => $e->getMessage()]];
            }
        });
    }

    public function provinces()
    {
        $data = $this->fetchFromApi('provinces.json', 'wilayah_provinces');
        return response()->json($data);
    }

    public function regencies($provCode)
    {
        $data = $this->fetchFromApi("regencies/{$provCode}.json", "wilayah_regencies_{$provCode}");
        return response()->json($data);
    }

    public function districts($regCode)
    {
        $data = $this->fetchFromApi("districts/{$regCode}.json", "wilayah_districts_{$regCode}");
        return response()->json($data);
    }

    public function villages($distCode)
    {
        $data = $this->fetchFromApi("villages/{$distCode}.json", "wilayah_villages_{$distCode}");
        return response()->json($data);
    }
}
