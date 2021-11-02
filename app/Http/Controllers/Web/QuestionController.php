<?php

namespace App\Http\Controllers\Web;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Question;
use App\Concern\Cacheable;
use Illuminate\Http\Request;

class QuestionController extends BaseController
{
    use Cacheable;

    protected function getTTL()
    {
        return 43200; // minutes - 30 day
    }

    public function index(Request $request)
    {
        $grate = $subject = null;
        $query = Question::with(['curriculum.course' => function ($query) {
                $query->with('grade', 'subject');
            }]);

        if ($request->lop) {
            $grate = Grade::where('slug', $request->lop)->first();
        }

        if ($request->mon) {
            $subject = Subject::where('slug', $request->mon)->first();
        }

        if ($grate || $subject) {
            $query->whereHas('curriculum.course', function($query) use ($grate, $subject) {
                if ($grate) {
                    $query->where('grade_id', $grate->id);
                }

                if ($subject) {
                    $query->where('subject_id', $subject->id);
                }
            });
        }

        if ($request->sort == 'trending') {
            $query->orderBy('view', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        $questions = $query->paginate(50);

        return view('web.questions.index')->with([
            'questions' => $questions,
        ]);
    }

    public function show(Question $question, $slug = null)
    {
        if ($slug != $question->slug) {
            return redirect()->route('question.show', [$question, $question->slug]);
        }

        $question->update([
            'view' => ++$question->view,
        ]);

        $curriculum = $question->curriculum->load(['questions' => function($query) use ($question) {
            $query->orderBy('view', 'desc')
                ->where('id', '<>', $question->id)
                ->limit(15)
                ->with('answers');
        }]);
        $course = $curriculum->course->load('grade', 'subject');

        // get new Questions
        $newQuestions = collect([]);
        $newCurriculum = Curriculum::whereHas('course', function($query) use ($course) {
                $query->where('status', Course::ACTIVE)
                    ->where('type', Course::TYPE_TEST)
                    ->where('subject_id', $course->subject_id)
                    ->where('grade_id', $course->grade_id);
            })
            ->whereHas('questions')
            ->where('status', Curriculum::ACTIVE)
            ->where('type', Curriculum::TYPE_TEST)
            ->orderBy('id', 'desc')
            ->first();

        if ($newCurriculum) {
            $newQuestions = Question::where('curriculum_id', $newCurriculum->id)
                ->orderBy('id', 'desc')
                ->limit(10)
                ->get();
        }
        // end
    
        $relatedExams = $this->getRelatedExamsWithCache($course->grade_id, $course->subject_id);

        return view('web.questions.show')->with([
            'question' => $question,
            'curriculum' => $curriculum,
            'course' => $course,
            'newQuestions' => $newQuestions,
            'relatedExams' => $relatedExams,
        ]);
    }

    private function getRelatedExamsWithCache($gradeId, $subjectId)
    {
        return $this->remember(function() use ($gradeId, $subjectId) {
            return Course::where('status', Course::ACTIVE)
                ->where('type', Course::TYPE_TEST)
                ->whereHas('curriculums')
                ->withCount('curriculums')
                ->where('subject_id', $subjectId)
                ->where('grade_id', $gradeId)
                ->orderBy('view', 'desc')
                ->limit(10)
                ->get();
        });
    }
}
