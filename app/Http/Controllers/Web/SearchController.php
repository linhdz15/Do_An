<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class SearchController extends BaseController
{
    public function search(Request $request)
    {
        $grade = $request->grade;
        $subject = $request->subject;
        $chapter = $request->chapter;
        $lesson = $request->lesson;
        $routeName = '';
        $parametersRoute = [];

        if ($request->grade) {
            $routeName = 'exam-by-grade';
            $parametersRoute[] = $request->grade;

            if ($request->subject) {
                $routeName = 'exam-by-grade-subject';
                $parametersRoute[] = $request->subject;

                if ($request->chapter) {
                    $routeName = 'exam-by-grade-subject-chapter';
                    $parametersRoute[] = $request->chapter;

                    if ($request->lesson) {
                        $routeName = 'exam-by-grade-subject-chapter-lesson';
                        $parametersRoute[] = $request->lesson;
                    }
                }
            }
        }

        return redirect()->route($routeName, $parametersRoute);
    }
}
