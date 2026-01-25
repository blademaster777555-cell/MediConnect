<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Gọi các seeders
        $this->call([
            CitySeeder::class,
            SpecializationSeeder::class,
        ]);

        // 3. Tạo tài khoản ADMIN (Để đăng nhập test ngay)
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'admin@mediconnect.com',
            'password' => Hash::make('12345678'), // Mật khẩu mẫu
            'role' => 1, // 1 là Admin (theo quy ước của bạn)
        ]);
        
        // 4. Tạo tài khoản BÁC SĨ mẫu
        $doctorId = DB::table('users')->insertGetId([
            'name' => 'Bác sĩ Nguyễn Văn A',
            'email' => 'bacsiA@mediconnect.com',
            'password' => Hash::make('12345678'),
            'role' => 2, // 2 là Doctor
        ]);
        
        // Gán thông tin chi tiết bác sĩ
        DB::table('doctor_profiles')->insert([ // <-- Thay doctors bằng doctor_profiles
        'user_id' => $doc1->id,
        'full_name' => 'Dr. Nguyễn Văn Minh',
        'specialization_id' => 1, // Giả sử 1 là ID của chuyên khoa Nội tổng quát
        'city_id' => 1, // Giả sử 1 là ID của Hà Nội
        'bio' => 'Bác sĩ chuyên khoa Nội tổng quát với hơn 10 năm kinh nghiệm.',
        'phone' => '0123456789',
        'license_number' => 'LS123456', // Số giấy phép hành nghề
        'consultation_fee' => 200000, // Phí khám 200,000 VND
        ]);

        DB::table('posts')->insert([
    [
        'title' => 'Cúm mùa và cách phòng tránh',
        'slug' => 'cum-mua',
        'summary' => 'Các biện pháp đơn giản để bảo vệ bản thân khỏi cúm mùa.',
        'content' => 'Nội dung chi tiết...',
        'image' => 'https://via.placeholder.com/600x400?text=Disease+Prevention',
        'type' => 'disease', // Loại: Bệnh học
        'created_at' => now(),
    ],
    [
        'title' => 'Công nghệ AI trong chẩn đoán ung thư',
        'slug' => 'ai-ung-thu',
        'summary' => 'Phát minh mới giúp phát hiện ung thư sớm nhờ trí tuệ nhân tạo.',
        'content' => 'Nội dung chi tiết...',
        'image' => 'https://via.placeholder.com/600x400?text=Invention',
        'type' => 'invention', // Loại: Phát minh
        'created_at' => now(),
    ],
    [
        'title' => 'Bộ Y tế khuyến cáo về dịch sốt xuất huyết',
        'slug' => 'sot-xuat-huyet',
        'summary' => 'Số ca mắc tăng cao, người dân cần chủ động diệt muỗi.',
        'content' => 'Nội dung chi tiết...',
        'image' => 'https://via.placeholder.com/600x400?text=Medical+News',
        'type' => 'news', // Loại: Tin tức
        'created_at' => now(),
    ],
]);

        // Counselor role removed — no seeder called
    }
}
