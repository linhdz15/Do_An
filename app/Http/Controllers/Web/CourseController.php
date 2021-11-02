<?php

namespace App\Http\Controllers\Web;

use App\Models\Grade;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\Course;
use App\Models\Curriculum;
use App\Models\Test;

class CourseController extends BaseController
{
    public function examByGrade(Grade $grade)
    {
        $subject = Subject::select('subjects.*')
            ->join('courses', function ($join) use ($grade) {
                $join->on('subjects.id', '=', 'courses.subject_id')
                    ->where('courses.grade_id', $grade->id)
                    ->where('courses.status', Course::ACTIVE)
                    ->where('courses.type', Course::TYPE_TEST);
            })
            ->groupBy('subjects.id')
            ->orderBy('subjects.id')
            ->first();

        if ($subject) {
            return redirect()->route('exam-by-grade-subject', [$grade, $subject]);
        }

        return redirect()->route('home')->with('message', 'Không tìm thấy kết quả!');
    }

    public function examByGradeSubject(Grade $grade, Subject $subject)
    {
        $subjects = Subject::select('subjects.*')
            ->join('courses', function ($join) use ($grade) {
                $join->on('subjects.id', '=', 'courses.subject_id')
                    ->where('courses.grade_id', $grade->id)
                    ->where('courses.status', Course::ACTIVE)
                    ->where('courses.type', Course::TYPE_TEST);
            })
            ->groupBy('subjects.id')
            ->orderBy('subjects.id')
            ->get();

        $chapters = Chapter::where('grade_id', $grade->id)
            ->where('subject_id', $subject->id)
            ->whereHas('courses', function ($query) {
                $query->where('status', Course::ACTIVE)
                    ->where('type', Course::TYPE_TEST)
                    ->whereHas('examCurriculums');
            })
            ->orderBy('index')
            ->orderBy('id')
            ->get();

        if ($chapters->isEmpty()) {
            $exams = Course::where('grade_id', $grade->id)
                ->where('subject_id', $subject->id)
                ->where('status', Course::ACTIVE)
                ->where('type', Course::TYPE_TEST)
                ->whereHas('examCurriculums')
                ->orderBy('view', 'desc')
                ->paginate(15);

            return view('web.exams.index')->with([
                'grade' => $grade,
                'subject' => $subject,
                'subjects' => $subjects,
                'exams' => $exams,
            ]);
        }

        $chapters->load(['lessons' => function($query) {
            $query->with(['courses' => function ($query) {
                $query->where('status', Course::ACTIVE)
                    ->where('type', Course::TYPE_TEST)
                    ->whereHas('examCurriculums')
                    ->withCount('examCurriculums as exam_count');
            }])
            ->orderBy('index');
        }])->load(['courses' => function ($query) { // get courses hasn't lesson
            $query->whereNull('lesson_id')
                ->where('status', Course::ACTIVE)
                ->where('type', Course::TYPE_TEST)
                ->whereHas('examCurriculums')
                ->withCount('examCurriculums as exam_count');
        }]);

        return view('web.exams.index')->with([
            'grade' => $grade,
            'subject' => $subject,
            'subjects' => $subjects,
            'chapters' => $chapters,
        ]);
    }

    public function examByGradeSubjectChapter(Grade $grade, Subject $subject, Chapter $chapter)
    {
        $subjects = Subject::select('subjects.*')
            ->join('courses', function ($join) use ($grade) {
                $join->on('subjects.id', '=', 'courses.subject_id')
                    ->where('courses.grade_id', $grade->id)
                    ->where('courses.status', Course::ACTIVE)
                    ->where('courses.type', Course::TYPE_TEST);
            })
            ->groupBy('subjects.id')
            ->orderBy('subjects.id')
            ->get();

        if ($chapter->lessons->isEmpty()) {
            $exams = Course::where('grade_id', $grade->id)
                ->where('subject_id', $subject->id)
                ->where('chapter_id', $chapter->id)
                ->whereNull('lesson_id')
                ->where('status', Course::ACTIVE)
                ->where('type', Course::TYPE_TEST)
                ->whereHas('examCurriculums')
                ->orderBy('view', 'desc')
                ->paginate(15);

            return view('web.exams.index')->with([
                'grade' => $grade,
                'subject' => $subject,
                'chapter' => $chapter,
                'subjects' => $subjects,
                'exams' => $exams,
            ]);
        }

        $chapter->load(['lessons' => function($query) {
            $query->with(['courses' => function ($query) {
                $query->where('status', Course::ACTIVE)
                    ->where('type', Course::TYPE_TEST)
                    ->whereHas('examCurriculums')
                    ->withCount('examCurriculums as exam_count');
            }])
            ->orderBy('index');
        }]);

        return view('web.exams.index')->with([
            'grade' => $grade,
            'subject' => $subject,
            'chapter' => $chapter,
            'subjects' => $subjects,
            'chapters' => collect([$chapter]),
        ]);
    }

    public function examByGradeSubjectChapterLesson(Grade $grade, Subject $subject, Chapter $chapter, Lesson $lesson)
    {
        $subjects = Subject::select('subjects.*')
            ->join('courses', function ($join) use ($grade) {
                $join->on('subjects.id', '=', 'courses.subject_id')
                    ->where('courses.grade_id', $grade->id)
                    ->where('courses.status', Course::ACTIVE)
                    ->where('courses.type', Course::TYPE_TEST);
            })
            ->groupBy('subjects.id')
            ->orderBy('subjects.id')
            ->get();
        $exams = Course::where('grade_id', $grade->id)
            ->where('subject_id', $subject->id)
            ->where('chapter_id', $chapter->id)
            ->where('lesson_id', $lesson->id)
            ->where('status', Course::ACTIVE)
            ->where('type', Course::TYPE_TEST)
            ->whereHas('examCurriculums')
            ->orderBy('view', 'desc')
            ->paginate(15);

        return view('web.exams.index')->with([
            'grade' => $grade,
            'subject' => $subject,
            'chapter' => $chapter,
            'lesson' => $lesson,
            'subjects' => $subjects,
            'exams' => $exams,
        ]);
    } 

    public function examShow($slug, $curriculumId = null)
    {
        $course = Course::where('slug', $slug)->first();

        if (!$course) {
            return redirect()->route('home')->with('error', 'Không tìm thấy bài thi!');
        }

        $course = $course->load([
            'examCurriculums' => function ($query) {
                $query->where('status', Curriculum::ACTIVE)
                    ->withCount('questions')
                    ->orderBy('index');
            }
        ]);

        if (!$curriculumId) {
            $curriculum = $course->examCurriculums->first();

            if ($curriculum) {
                return redirect()->route('exam.show', [$course->slug, $curriculum->id]);
            } else {
                return redirect()->route('home')->with('error', 'Bài thi đang cập nhật!');
            }
        }

        $curriculum = Curriculum::where('id', $curriculumId)
            ->where('course_id', $course->id)
            ->first();

        if (!$curriculum) {
            return redirect()->route('home')->with('error', 'Bài thi đang cập nhật!');
        }

        $chapters = Chapter::where('grade_id', $course->grade_id)
            ->where('subject_id', $course->subject_id)
            ->whereHas('courses', function ($query) {
                $query->where('status', Course::ACTIVE)
                    ->where('type', Course::TYPE_TEST);
            })
            ->with(['lessons' => function ($query) {
                $query->with(['courses' => function ($que) {
                    $que->where('status', Course::ACTIVE)
                        ->where('type', Course::TYPE_TEST);
                }])->orderBy('index')->orderBy('id');
            }])
            ->with(['courses' => function ($query) { // get courses hasn't lesson
                $query->whereNull('lesson_id')
                    ->where('status', Course::ACTIVE)
                    ->where('type', Course::TYPE_TEST);
            }])
            ->orderBy('index')
            ->orderBy('id')
            ->get();

        $curriculum->loadCount('questions')
            ->load(['questions' => function ($query) {
                $query->with('answers')
                    ->orderBy('index');
            }]);

        $course->increment('view');
        $curriculum->increment('view');

        return view('web.exams.show')->with([
            'course' => $course,
            'curriculum' => $curriculum,
            'chapters' => $chapters,
        ]);
    }

    public function startExam(Curriculum $curriculum, $slug = null)
    {
        if ($slug != $curriculum->slug) {
            return redirect()->route('exam.start', [$curriculum, $curriculum->slug]);
        }

        $curriculum->load('questions.answers');

        $exams = Curriculum::where('course_id', $curriculum->course_id)
            ->where(function($query) {
                $query->whereNotNull('parent_id')
                      ->where('parent_id', '<>', 0);
            })
            ->whereHas('questions')
            ->orderBy('index')
            ->get();

        $test = Test::create([
            'user_id' => auth()->id(),
            'curriculum_id' => $curriculum->id,
            'started_at' => now(),
        ]);

        session()->put('current_test', $test->id);

        return view('web.exams.start-exam')->with([
            'curriculum' => $curriculum,
            'exams' => $exams,
            'test' => $test,
        ]);
    }
}
