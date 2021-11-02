<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\QuestionRequest;
use App\Models\Course;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class QuestionController extends BaseController
{
    public function __construct()
    {
        //
    }

    public function store(QuestionRequest $request)
    {
        $this->authorize('create', Question::class);

        if ($request->expectsJson()) {
            DB::beginTransaction();

            try {
                $maxIndex = Question::where('curriculum_id', $request->curriculum_id)->max('index');

                $question = Question::create([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request->content,
                    'reason' => $request->reason,
                    'curriculum_id' => $request->curriculum_id,
                    'editor_id' => auth()->id(),
                    'index' => $maxIndex + 1,
                    'status' => Question::ACTIVE,
                ]);

                if (!empty($request->answers)) {
                    $answers = [];

                    foreach ($request->answers as $key => $answer) {
                        if ($answer['content']) {
                            $answers[] = [
                                'question_id' => $question->id,
                                'content' => $answer['content'],
                                'answer' => ($request->checkAnswer == $key) ? Answer::RIGHT : Answer::WRONG,
                                'created_at' => now(), // insert function not auto add created_at, updated_at column
                                'updated_at' => now(),
                            ];
                        }
                    }

                    Answer::insert($answers);
                }

                DB::commit();

                return $this->jsonSuccess([
                    'question' => $question->load('answers'),
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return $this->jsonError([
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    public function update(QuestionRequest $request, Course $course, Question $question)
    {
        $this->authorize('crud', $question);

        if ($request->expectsJson()) {
            DB::beginTransaction();

            try {
                $question->update([
                    'title' => $request->title,
                    'slug' => $request->slug,
                    'content' => $request->content,
                    'reason' => $request->reason,
                    'editor_id' => auth()->id(),
                    'edited_at' => now(),
                ]);

                if (!empty($request->answers)) {
                    // Delete all old answer
                    Answer::where('question_id', $question->id)->delete();

                    $answers = [];

                    foreach ($request->answers as $key => $answer) {
                        if ($answer['content']) {
                            $answers[] = [
                                'question_id' => $question->id,
                                'content' => $answer['content'],
                                'answer' => ($request->checkAnswer == $key) ? Answer::RIGHT : Answer::WRONG,
                                'created_at' => now(), // insert function not auto add created_at, updated_at column
                                'updated_at' => now(),
                            ];
                        }
                    }

                    Answer::insert($answers);
                }

                DB::commit();

                return $this->jsonSuccess([
                    'question' => $question->load('answers'),
                ]);
            } catch (\Exception $e) {
                DB::rollback();

                return $this->jsonError([
                    'message' => $e->getMessage(),
                ]);
            }
        }
    }

    public function destroy(Request $request, Course $course, Question $question)
    {
        $this->authorize('crud', $question);

        if ($request->expectsJson()) {
            $question->delete();

            return $this->jsonSuccess([
                'deteled' => true,
            ]);
        }
    }

    public function sort(Request $request)
    {
        DB::beginTransaction();

        try {
            $questions = $request->questions;

            foreach ($questions as $index => $question) {
                Question::where('id', $question['id'])->update([
                    'index' => $index
                ]);
            }

            DB::commit();

            return $this->jsonSuccess([
                'sorted' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return $this->jsonError([
                'message' => $e->getMessage(),
            ]);
        }
    }
}
