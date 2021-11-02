<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\User;

class SuggestController extends Controller
{
    protected function select2SuggestWithPaging(
        Request $request,
        $query,
        $nameColumn,
        $otherColumns = [],
        $resultCallback = null
    )
    {
        if ($selectedIds = $request->input('selectedValues')) {
            $selectedIds = explode(',', $selectedIds);

            $query = $query->whereIn('id', $selectedIds);
        } else {
            $q = $request->input('q');

            $query = $query->whereLike($nameColumn, $q);
        }

        $paginatedResults = $query->select("$nameColumn as text", 'id');
        if ($otherColumns) {
            $paginatedResults->addSelect($otherColumns);
        }
        $paginatedResults = $paginatedResults->paginate();

        $results = $paginatedResults->items();

        return response()->json([
            'results' => is_callable($resultCallback) ? $resultCallback($results) : $results,
            'pagination' => [
                'more' => $paginatedResults->hasMorePages(),
            ],
        ]);
    }

    public function grades(Request $request)
    {
        return $this->select2SuggestWithPaging(
            $request,
            Grade::query(),
            'title',
            ['slug']
        );
    }

    public function subjects(Request $request)
    {
        $query = Subject::query();

        if (!$request->input('all') && $request->input('grade_id')) {
            $query->whereHas('grades', function ($q) use ($request) {
                $q->where('grades.id', $request->grade_id);
            });
        }

        if ($request->input('grade_slug')) {
            $query->whereHas('grades', function ($q) use ($request) {
                $q->where('grades.slug', $request->grade_slug);
            });
        }

        return $this->select2SuggestWithPaging(
            $request,
            $query,
            'title',
            ['slug']
        );
    }

    public function chapters(Request $request)
    {
        $query = Chapter::query();

        if ($request->input('grade_id')) {
            $query->whereHas('grade', function ($q) use ($request) {
                $q->where('id', $request->grade_id);
            });
        }

        if ($request->input('subject_id')) {
            $query->whereHas('subject', function ($q) use ($request) {
                $q->where('id', $request->subject_id);
            });
        }

        if ($request->input('grade_slug')) {
            $query->whereHas('grade', function ($q) use ($request) {
                $q->where('slug', $request->grade_slug);
            });
        }

        if ($request->input('subject_slug')) {
            $query->whereHas('subject', function ($q) use ($request) {
                $q->where('slug', $request->subject_slug);
            });
        }

        return $this->select2SuggestWithPaging(
            $request,
            $query,
            'title',
            ['slug']
        );
    }

    public function lessons(Request $request)
    {
        $query = Lesson::query();

        if ($request->input('chapter_id')) {
            $query->where('chapter_id', $request->input('chapter_id'));
        }

        if ($request->input('chapter_slug')) {
            $query->whereHas('chapter', function ($q) use ($request) {
                $q->where('slug', $request->chapter_slug);
            });
        }

        return $this->select2SuggestWithPaging(
            $request,
            $query,
            'title',
            ['slug']
        );
    }

    public function users(Request $request)
    {
        $query = User::where('role', $request->input('role') ?? User::ADMIN);

        return $this->select2SuggestWithPaging(
            $request,
            $query,
            'name'
        );
    }
}
