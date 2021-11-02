<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects = [
            'Toán',
            'Văn',
            'Vật lý',
            'Hóa học',
            'Tiếng Anh',
            'Lịch sử',
            'Địa lý',
            'Sinh học',
            'Công nghệ',
            'Giáo dục công dân',
            'Tiếng Việt',
            'Tin học',
            'Đạo đức',
            'Tự nhiên & Xã hội',
            'Khoa học',
            'Lịch sử & địa lý',
            'Khoa học xã hội',
            'Tiếng Anh (mới)',
            'Pháp luật'
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                [
                    'title' => $subject
                ],
                [
                    'slug' => Str::slug($subject),
                    'status' => 1,
                    'editor_id' => 1,
                    'seo_title' => $subject,
                    'seo_description' => $subject,
                    'seo_keywords' => $subject
                ]
            );
        }
    }
}
