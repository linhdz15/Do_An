<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('question-statistics');

        $dateRange = $request->dates;

        if ($dateRange) {
            $startDate = sprintf(
                '%s-%s-%s',
                substr($dateRange, 0, 4),
                substr($dateRange, 5, 2),
                substr($dateRange, 8, 2)
            );

            $endDate = sprintf(
                '%s-%s-%s',
                substr($dateRange, 13, 4),
                substr($dateRange, 18, 2),
                substr($dateRange, 21, 2)
            );
        } else {
            $startDate = now()->format('Y-m-d');
            $endDate = now()->format('Y-m-d');
        }

        $users = User::join('questions', 'users.id', '=', 'questions.editor_id')
            ->join('curriculums', 'curriculums.id', '=', 'questions.curriculum_id')
            ->groupBy('users.id', 'users.email', 'curriculums.id')
            ->where('questions.updated_at', '>=', $startDate . ' 00:00:00')
            ->where('questions.updated_at', '<=', $endDate . ' 23:59:59')
            ->select([
                'users.id',
                'users.email',
                'users.name',
                DB::raw('COUNT(questions.id) as question_number'),
                'curriculums.id AS curriculums_id',
                'curriculums.title',
                'curriculums.course_id'
            ])
            ->get()
            ->groupBy('email');

        return view('admin.statistics.index', [
            'users' => $users,
            'dateRange' => $dateRange,
            'totalQuestionNumber' => array_sum(array_column($users->flatten(1)->toArray(), 'question_number'))
        ]);
    }
}
