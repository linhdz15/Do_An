<?php

namespace App\Http\Controllers\Web;

use App\Models\Grade;
use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Support\Facades\DB;

class HomeController extends BaseController
{
    public function index(){
        $grades = Grade::select('grades.*', DB::raw('count("curriculums.id") as exam_count'))
            ->join('courses', function ($join) {
                $join->on('grades.id', '=', 'courses.grade_id')
                    ->where('courses.type', Course::TYPE_TEST)
                    ->where('courses.status', Course::ACTIVE);
            })->join('curriculums', 'courses.id', '=', 'curriculums.course_id')
            ->groupBy('grades.id')
            ->orderBy('grades.id', 'desc')
            ->get();

        return view('web.home.index')->with([
            'grades' => $grades,
        ]);
    	return view('web.home.index');
    }
}
