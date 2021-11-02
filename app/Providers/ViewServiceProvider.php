<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\View\Composers\WebMenuComposer;
use App\View\Composers\ExamTrendingComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {   
        View::composer([
            'web.components.header',
            'web.questions.partials.sidebar-filter'
        ], WebMenuComposer::class);
        View::composer('web.components.headline', ExamTrendingComposer::class);
    }
}
