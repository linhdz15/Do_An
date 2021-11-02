<?php

namespace App\Http\Controllers\Web;

use App\Models\Test;
use App\Models\Question;
use App\Models\Answer;
use App\Models\TestDetail;
use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends BaseController
{
    public function sendAnswer(Test $test, Request $request)
    {
        $this->authorize('origin', $test);

        if ($request->expectsJson() && session()->has('current_test') &&
            $test->id == session('current_test')) {
            $question = Question::find($request->question_id);

            if ($question) {
                $status = TestDetail::CORRECT;
                $right_answer_index = null;
                $choose_answer_index = $request->choose_answer_index;

                if ($question->answers->count() == 0) {

                } else {
                    foreach ($question->answers as $key => $answer) {
                        if ($answer->answer == Answer::RIGHT) {
                            $right_answer_index = $key;
                        }
                    }

                    $status = (!is_null($choose_answer_index) &&
                        $choose_answer_index == $right_answer_index) ?
                        TestDetail::CORRECT :
                        TestDetail::FAILED;
                }

                DB::transaction(function () use (
                    $test,
                    $question,
                    $right_answer_index,
                    $choose_answer_index, $status
                ) {
                    TestDetail::updateOrCreate(
                        [
                            'test_id' => $test->id,
                            'question_id' => $question->id,
                        ],
                        [
                            'right_answer_index' => $right_answer_index,
                            'choose_answer_index' => $choose_answer_index,
                            'status' => $status,
                        ]
                    );

                    $test->update([
                        'ended_at' => now(),
                    ]);
                });

                return $this->jsonSuccess('done!', [
                    'question' => $question,
                    'status' => $status,
                    'right_answer' => $right_answer_index,
                ]);
            }
        } else {
            return $this->jsonServerError();
        }
    }

    public function submitTest(Test $test, Request $request)
    {
        $this->authorize('origin', $test);

        $test->update([
            'ended_at' => now(),
        ]);

        if ($request->expectsJson()) {
            return $this->jsonSuccess('submited!', [
                'redirectTo' => route('test.result', $test),
            ]);
        }

        return redirect()->route('test.result', $test); 
    }

    public function testResult(Test $test)
    {
        $this->authorize('origin', $test);

        $curriculum = Curriculum::findOrFail($test->curriculum_id);
        $nextCurriculum = Curriculum::where('course_id', $curriculum->course_id)
            ->where(function($query) {
                $query->whereNotNull('parent_id')
                      ->where('parent_id', '<>', 0);
            })
            ->where('index', '>', $curriculum->index)
            ->whereHas('questions')
            ->orderBy('index')
            ->first();

        return view('web.exams.result-exam')->with([
            'test' => $test,
            'curriculum' => $curriculum->load('questions.answers'),
            'nextCurriculum' => $nextCurriculum,
            'course' => $curriculum->course,
        ]);
    }
}
