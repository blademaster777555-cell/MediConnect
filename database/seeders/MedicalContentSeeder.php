<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class MedicalContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure Admin exists to be the author
        $admin = User::where('role', 'admin')->first() ?? User::first();
        $adminId = $admin ? $admin->id : 1;

        $now = Carbon::now();

        $contents = [
            // Category: disease (Bệnh phổ biến & Phòng ngừa)
            [
                'title' => 'Bệnh Cúm Mùa: Triệu chứng và Cách phòng ngừa',
                'category' => 'disease',
                'content' => 'Bệnh cúm mùa là một nhiễm trùng đường hô hấp cấp tính do virus cúm gây ra. Triệu chứng bao gồm sốt đột ngột, ho, đau đầu, đau cơ, mệt mỏi, đau họng và chảy nước mũi. Để phòng ngừa, hãy tiêm vắc xin cúm hàng năm, rửa tay thường xuyên và tránh tiếp xúc gần với người bệnh.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(1),
                'created_at' => $now, 
                'updated_at' => $now,
            ],
            [
                'title' => 'Đái tháo đường (Tiểu đường) - Kẻ giết người thầm lặng',
                'category' => 'disease',
                'content' => 'Đái tháo đường là bệnh rối loạn chuyển hóa mạn tính. Triệu chứng thường gặp: khát nước nhiều, đi tiểu nhiều, sụt cân nhanh, mờ mắt. Phòng ngừa bằng cách duy trì cân nặng hợp lý, vận động thể lực ít nhất 30 phút mỗi ngày và ăn uống lành mạnh hạn chế đường.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(2),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Tăng Huyết Áp: Những điều cần biết',
                'category' => 'disease',
                'content' => 'Tăng huyết áp được mệnh danh là "kẻ giết người thầm lặng" vì thường không có triệu chứng rõ ràng. Biến chứng nguy hiểm gồm đột quỵ, nhồi máu cơ tim, suy thận. Kiểm soát bằng cách ăn nhạt, hạn chế rượu bia, không hút thuốc lá và đo huyết áp thường xuyên.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(5),
                'created_at' => $now,
                'updated_at' => $now,
            ],
             [
                'title' => 'Sốt xuất huyết: Dấu hiệu cảnh báo nguy hiểm',
                'category' => 'disease',
                'content' => 'Sốt xuất huyết do virus Dengue gây ra, lây truyền qua muỗi vằn. Dấu hiệu cảnh báo: Đau bụng dữ dội, nôn liên tục, chảy máu lợi, nôn ra máu, thở nhanh, mệt mỏi, bồn chồn. Khi có dấu hiệu này cần nhập viện ngay lập tức.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(10),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Category: news (Tin tức Y tế)
            [
                'title' => 'Bộ Y tế phát động chiến dịch tiêm chủng vắc xin sởi',
                'category' => 'news',
                'content' => 'Bộ Y tế vừa phát động chiến dịch tiêm chủng vắc xin sởi - rubella cho trẻ em trên toàn quốc nhằm ứng phó với nguy cơ dịch sởi quay trở lại. Chiến dịch sẽ diễn ra tại 63 tỉnh thành, ưu tiên các vùng khó khăn, vùng sâu vùng xa.',
                'author_id' => $adminId,
                'published_date' => $now->subHours(2),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Công nghệ AI trong chẩn đoán hình ảnh: Bước tiến mới của Y học',
                'category' => 'news',
                'content' => 'Việc ứng dụng Trí tuệ nhân tạo (AI) trong chẩn đoán hình ảnh đang giúp các bác sĩ phát hiện sớm ung thư phổi và ung thư vú với độ chính xác lên tới 95%. Nhiều bệnh viện lớn tại Việt Nam đã bắt đầu triển khai hệ thống này.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(1),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Hội thảo Quốc tế về Tim mạch học 2024 tổ chức tại Hà Nội',
                'category' => 'news',
                'content' => 'Hơn 500 chuyên gia tim mạch hàng đầu thế giới đã tụ họp tại Hà Nội để chia sẻ những cập nhật mới nhất về điều trị suy tim và can thiệp mạch vành. Hội thảo mang lại nhiều cơ hội hợp tác và phát triển cho ngành y tế nước nhà.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(3),
                'created_at' => $now,
                'updated_at' => $now,
            ],
             [
                'title' => 'Cảnh báo về tình trạng lạm dụng thuốc kháng sinh',
                'category' => 'news',
                'content' => 'Tổ chức Y tế Thế giới (WHO) cảnh báo tình trạng kháng thuốc kháng sinh đang ở mức báo động. Người dân được khuyến cáo không tự ý mua thuốc kháng sinh mà phải tuân thủ kê đơn của bác sĩ để bảo vệ sức khỏe cộng đồng.',
                'author_id' => $adminId,
                'published_date' => $now->subDays(4),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('medical_content')->insert($contents);
    }
}
