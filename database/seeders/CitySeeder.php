<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            'Hà Nội',
            'Hồ Chí Minh',
            'Đà Nẵng',
            'Cần Thơ',
            'Hải Phòng',
            'Biên Hòa',
            'Vũng Tàu',
            'Nha Trang',
            'Huế',
            'Quy Nhơn',
        ];

        foreach ($cities as $cityName) {
            City::firstOrCreate(['name' => $cityName]);
        }
    }
}
