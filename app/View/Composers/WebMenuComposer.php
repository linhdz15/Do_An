<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Concern\Cacheable;
use App\Models\Course;
use DB;

class WebMenuComposer
{
    use Cacheable;

    protected function getTTL()
    {
        return 43200; // minutes - 30 day
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('menus', $this->getMenuWithCache());
    }

    private function getMenuWithCache()
    {
        return $this->remember(function () {
            $datas = DB::select("
                SELECT
                    grades.id as grade_id,
                    grades.title as grade_title,
                    grades.slug as grade_slug,
                    subjects.id as subject_id,
                    subjects.title as subject_title,
                    subjects.slug as subject_slug,
                    subjects.icon as subject_icon,
                    count(curriculums.id) as exam_count
                FROM
                    grades
                        JOIN
                    courses ON grades.id = courses.grade_id
                        AND courses.type = ?
                        AND courses.status = ?
                        JOIN
                    subjects ON subjects.id = courses.subject_id
                    JOIN
                    curriculums ON courses.id = curriculums.course_id
                GROUP BY grades.id , subjects.id
                ORDER BY grades.id DESC;
            ", [Course::TYPE_TEST, Course::ACTIVE]);

            $grades = [];
            $groupSubjects = [];

            foreach ($datas as $data) {
                $dataArr = get_object_vars($data);
                $gradeArr = [
                    'id' => $dataArr['grade_id'],
                    'title' => $dataArr['grade_title'],
                    'slug' => $dataArr['grade_slug'],
                ];
                $subjectArr = [
                    'id' => $dataArr['subject_id'],
                    'title' => $dataArr['subject_title'],
                    'slug' => $dataArr['subject_slug'],
                    'icon' => $dataArr['subject_icon'],
                    'exam_count' => $dataArr['exam_count'],
                ];
                $groupSubjects[$dataArr['grade_id']][] = $subjectArr;
                $grades[$dataArr['grade_id']] = $gradeArr;
            }
            return ['grades' => $grades, 'subjects' => $groupSubjects];
        });
    }
}
