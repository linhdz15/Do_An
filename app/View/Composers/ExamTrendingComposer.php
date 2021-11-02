<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Concern\Cacheable;
use App\Models\Curriculum;

class ExamTrendingComposer
{
    use Cacheable;

    protected function getTTL()
    {
        return 288; // minutes - 2 day
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('examTrendings', $this->getExamTrendingsWithCache());
    }

    private function getExamTrendingsWithCache()
    {
        return $this->remember(function () {
            return Curriculum::where('status', Curriculum::ACTIVE)
                ->where(function($query) {
                    $query->whereNotNull('parent_id')
                        ->where('parent_id', '<>', 0);
                })
                ->where('type', Curriculum::TYPE_TEST)
                ->with('course.grade', 'course.subject')
                ->orderBy('view', 'desc')
                ->limit(10)
                ->get();
        });
    }
}
