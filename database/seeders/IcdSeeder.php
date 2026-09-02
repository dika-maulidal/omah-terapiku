<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Icd;

class IcdSeeder extends Seeder
{
    public function run(): void
    {
        $icds = [
            ['code' => 'G80.0', 'name_id' => 'Cerebral Palsy Spastik Quadriplegia', 'name_en' => 'Spastic quadriplegic cerebral palsy'],
            ['code' => 'G80.1', 'name_id' => 'Cerebral Palsy Spastik Diplegia', 'name_en' => 'Spastic diplegic cerebral palsy'],
            ['code' => 'G80.2', 'name_id' => 'Cerebral Palsy Spastik Hemiplegia', 'name_en' => 'Spastic hemiplegic cerebral palsy'],
            ['code' => 'G80.9', 'name_id' => 'Cerebral Palsy, Tidak Ditentukan', 'name_en' => 'Cerebral palsy, unspecified'],
            ['code' => 'F84.0', 'name_id' => 'Autisme Masa Kanak (Autistic Disorder)', 'name_en' => 'Childhood autism'],
            ['code' => 'F84.5', 'name_id' => 'Sindrom Asperger', 'name_en' => 'Asperger syndrome'],
            ['code' => 'F80.1', 'name_id' => 'Gangguan Bahasa Ekspresif (Speech Delay)', 'name_en' => 'Expressive language disorder'],
            ['code' => 'F80.2', 'name_id' => 'Gangguan Bahasa Reseptif', 'name_en' => 'Receptive language disorder'],
            ['code' => 'F82',   'name_id' => 'Gangguan Perkembangan Koordinasi Motorik (Dispraksia)', 'name_en' => 'Specific developmental disorder of motor function'],
            ['code' => 'F90.0', 'name_id' => 'Gangguan Pemusatan Perhatian dan Hiperaktivitas (ADHD)', 'name_en' => 'Disturbance of activity and attention'],
            ['code' => 'Q90.9', 'name_id' => 'Sindrom Down, Tidak Ditentukan', 'name_en' => 'Down syndrome, unspecified'],
            ['code' => 'I69.3', 'name_id' => 'Sekuela Infark Serebral (Pasca Stroke Iskemik)', 'name_en' => 'Sequelae of cerebral infarction'],
            ['code' => 'I69.4', 'name_id' => 'Sekuela Stroke, Tidak Ditentukan (Hemiparesis Pasca Stroke)', 'name_en' => 'Sequelae of stroke, not specified as haemorrhage or infarction'],
            ['code' => 'H54.0', 'name_id' => 'Kebutaan Kedua Mata (Blindness, Both Eyes)', 'name_en' => 'Blindness, both eyes'],
            ['code' => 'H54.2', 'name_id' => 'Low Vision / Penglihatan Rendah Kedua Mata', 'name_en' => 'Low vision, both eyes'],
            ['code' => 'M62.8', 'name_id' => 'Kelemahan dan Gangguan Otot Lainnya', 'name_en' => 'Other specified disorders of muscle'],
            ['code' => 'R26.2', 'name_id' => 'Kesulitan Berjalan / Gangguan Gaya Berjalan (Gait Difficulty)', 'name_en' => 'Difficulty in walking, not elsewhere classified'],
            ['code' => 'R62.0', 'name_id' => 'Keterlambatan Pencapaian Tahap Perkembangan Fisiologis (Global Developmental Delay)', 'name_en' => 'Delayed milestone in childhood'],
        ];

        foreach ($icds as $icd) {
            Icd::updateOrCreate(
                ['code' => $icd['code']],
                $icd
            );
        }
    }
}
