<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 12; $i++) {
            Grade::firstOrCreate(
                ['title' => 'Lớp ' . $i],
                [
                    'slug' => 'lop-' . $i,
                    'status' => 1,
                    'type' => $this->getGradeType($i),
                    'editor_id' => 1,
                    'seo_title' => 'Lớp ' . $i,
                    'seo_description' => 'Lớp ' . $i,
                    'seo_keywords' => 'Lớp ' . $i
                ]
            );
        }
    }

    public function getGradeType($grade)
    {
        if ($grade >= 1 && $grade <= 5) {
            return Grade::PRE_SCHOOL;
        } elseif ($grade >= 6 && $grade <= 9) {
            return Grade::JUNIOR_SCHOOL;
        } else {
            return Grade::HIGH_SCHOOL;
        }
    }
}
