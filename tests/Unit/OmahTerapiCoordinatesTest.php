<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Poli;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OmahTerapiCoordinatesTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_create_and_update_poli_with_coordinates()
    {
        $poli = Poli::create([
            'nama' => 'UPT Test Unit Kediri',
            'alamat' => 'Jl. Dhoho No. 10, Kediri',
            'no_telp' => '081234567890',
            'latitude' => '-7.8167000',
            'longitude' => '112.0117000',
            'fokus_layanan' => 'Anak Berkebutuhan Khusus (ABK)',
            'status' => 1,
        ]);

        $this->assertDatabaseHas('omahterapiku', [
            'nama' => 'UPT Test Unit Kediri',
            'latitude' => '-7.8167000',
            'longitude' => '112.0117000',
        ]);

        $poli->update([
            'latitude' => '-7.8200000',
            'longitude' => '112.0200000',
        ]);

        $this->assertDatabaseHas('omahterapiku', [
            'nama' => 'UPT Test Unit Kediri',
            'latitude' => '-7.8200000',
            'longitude' => '112.0200000',
        ]);
    }

    /** @test */
    public function it_fetches_dynamic_balai_points_in_laporan_data()
    {
        Poli::create([
            'nama' => 'UPT Dynamic Unit Blitar',
            'alamat' => 'Jl. Merdeka No. 1, Blitar',
            'latitude' => '-8.0983000',
            'longitude' => '112.1681000',
            'fokus_layanan' => 'Pelayanan Terapi Terpadu',
            'status' => 1,
        ]);

        $controller = new \App\Http\Controllers\LaporanController();
        $reflection = new \ReflectionClass($controller);
        $method = $reflection->getMethod('computeReportData');
        $method->setAccessible(true);

        $meta = [
            'start_date' => \Carbon\Carbon::now()->startOfMonth(),
            'end_date' => \Carbon\Carbon::now()->endOfMonth(),
            'upt' => 'all',
            'layanan' => 'all',
        ];

        $reportData = $method->invoke($controller, $meta);

        $this->assertArrayHasKey('map_balai_points', $reportData);
        $balaiNames = array_column($reportData['map_balai_points'], 'nama');
        $this->assertContains('UPT Dynamic Unit Blitar', $balaiNames);
    }

    /** @test */
    public function it_prevents_assigning_terapis_already_in_another_upt()
    {
        $terapis1 = \App\Models\Dokter::create([
            'nama' => 'Terapis UPT A',
            'no_hp' => '08111111111',
            'status' => 1,
            'poli' => 'UPT Asal',
        ]);

        $terapis2 = \App\Models\Dokter::create([
            'nama' => 'Terapis Bebas',
            'no_hp' => '08222222222',
            'status' => 1,
            'poli' => null,
        ]);

        $controller = new \App\Http\Controllers\PoliController();
        $request = new \Illuminate\Http\Request([
            'nama' => 'UPT Baru Unik',
            'terapis_ids' => [$terapis1->id, $terapis2->id],
        ]);

        $controller->store($request);

        // Terapis 1 should still belong to 'UPT Asal'
        $this->assertEquals('UPT Asal', $terapis1->fresh()->poli);

        // Terapis 2 should belong to 'UPT Baru Unik'
        $this->assertEquals('UPT Baru Unik', $terapis2->fresh()->poli);
    }
}
