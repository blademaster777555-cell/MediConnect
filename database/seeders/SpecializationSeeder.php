<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialization;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            [
                'name' => 'Nội khoa',
                'description' => 'Chuyên khoa nội khoa tổng quát, điều trị các bệnh lý nội khoa'
            ],
            [
                'name' => 'Nhi khoa',
                'description' => 'Chuyên khoa nhi khoa, chăm sóc sức khỏe trẻ em'
            ],
            [
                'name' => 'Sản phụ khoa',
                'description' => 'Chuyên khoa sản phụ khoa, chăm sóc sức khỏe phụ nữ và thai sản'
            ],
            [
                'name' => 'Da liễu',
                'description' => 'Chuyên khoa da liễu, điều trị các bệnh về da'
            ],
            [
                'name' => 'Mắt',
                'description' => 'Chuyên khoa mắt, khám và điều trị các bệnh về mắt'
            ],
            [
                'name' => 'Tai mũi họng',
                'description' => 'Chuyên khoa tai mũi họng, điều trị các bệnh về tai, mũi, họng'
            ],
            [
                'name' => 'Răng hàm mặt',
                'description' => 'Chuyên khoa răng hàm mặt, chăm sóc răng miệng'
            ],
            [
                'name' => 'Tim mạch',
                'description' => 'Chuyên khoa tim mạch, điều trị các bệnh về tim mạch'
            ],
            [
                'name' => 'Tiêu hóa',
                'description' => 'Chuyên khoa tiêu hóa, điều trị các bệnh về đường tiêu hóa'
            ],
            [
                'name' => 'Cơ xương khớp',
                'description' => 'Chuyên khoa cơ xương khớp, điều trị các bệnh về cơ xương khớp'
            ],
        ];

        foreach ($specializations as $spec) {
            Specialization::firstOrCreate(
                ['name' => $spec['name']],
                ['description' => $spec['description']]
            );
        }
    }
}
