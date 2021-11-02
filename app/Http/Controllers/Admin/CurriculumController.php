<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\CurriculumRequest;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class CurriculumController extends BaseController
{
    public function __construct()
    {
        //
    }

    public function index(Request $request, Course $course)
    {
        if ($request->expectsJson()) {
            $curriculums = Curriculum::where('course_id', $course->id)
                ->withCount('questions')
                ->orderBy('index')
                ->get();

            return $this->jsonSuccess([
                'curriculums' => $curriculums,
            ]);
        }

        return view('admin.courses.curriculums.index', [
            'course' => $course,
        ]);
    }

    public function getQuestions(Request $request, Course $course, Curriculum $curriculum)
    {
        if ($request->expectsJson()) {
            $questions = Question::where('curriculum_id', $curriculum->id)
                ->with('answers')
                ->orderBy('index')
                ->get();

            return $this->jsonSuccess([
                'questions' => $questions,
            ]);
        }
    }

    public function store(CurriculumRequest $request, Course $course)
    {
        $this->authorize('create', Course::class);

        if ($request->expectsJson()) {
            $maxIndex = Curriculum::where('course_id', $course->id)->max('index');
            $parentId = null;

            if (!$request->isCurriculumParent) {
                $parentCurriculum = Curriculum::whereNull('parent_id')
                    ->where('course_id', $course->id)
                    ->orderBy('index', 'desc')
                    ->first();

                $parentId = $parentCurriculum->id ?? null;
            }

            $curriculum = Curriculum::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'time' => $request->time,
                'score' => $request->score,
                'course_id' => $course->id,
                'status' => Curriculum::ACTIVE,
                'index' => $maxIndex + 1,
                'parent_id' => $parentId,
                'type' => $course->type,
            ]);

            return $this->jsonSuccess([
                'curriculum' => $curriculum->loadCount('questions'),
            ]);
        }
    }

    public function update(CurriculumRequest $request, Course $course, Curriculum $curriculum)
    {
        $this->authorize('edit', $course);

        if ($request->expectsJson()) {
            $curriculum->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'description' => $request->description,
                'time' => $request->time,
                'score' => $request->score,
                'course_id' => $course->id,
            ]);

            return $this->jsonSuccess([
                'curriculum' => $curriculum->loadCount('questions'),
            ]);
        }
    }

    public function destroy(Request $request, Course $course, Curriculum $curriculum)
    {
        $this->authorize('delete', $course);

        if ($request->expectsJson()) {
            $curriculum->loadCount('children', 'questions');

            if ($curriculum->children_count > 0 || $curriculum->questions_count > 0) {
                return $this->jsonError([
                    'message' => 'Cần xóa hết nội dung con bên trong bản ghi này trước!',
                ]);
            } else {
                $curriculum->delete();

                return $this->jsonSuccess([
                    'deteled' => true,
                ]);
            }
        }
    }

    public function sort(Request $request, Course $course)
    {
        DB::beginTransaction();

        try {
            $curriculums = $request->curriculums;
            $lastParent = null;

            foreach ($curriculums as $index => $curriculum) {
                $update = [
                    'index' => $index
                ];

                if ($lastParent && $curriculum['parent_id']) {
                    $update['parent_id'] = $lastParent['id'];
                } else {
                    $update['parent_id'] = null;
                }

                Curriculum::where('id', $curriculum['id'])->update($update);

                if (!$curriculum['parent_id']) {
                    $lastParent = $curriculum;
                }
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
