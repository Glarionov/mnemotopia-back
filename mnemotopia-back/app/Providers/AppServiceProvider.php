<?php

namespace App\Providers;

use App\Interfaces\Group\ChainElementsServiceInterface;
use App\Interfaces\Group\ChainServiceInterface;
use App\Interfaces\Group\GroupServiceInterface;
use App\Interfaces\Group\QuestionsServiceInterface;
use App\Services\Group\ChainElementService;
use App\Services\Group\ChainService;
use App\Services\Group\GroupService;
use App\Services\Group\QuestionService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        DB::enableQueryLog();//todo r
        $this->app->bind(GroupServiceInterface::class, GroupService::class);
        $this->app->bind(ChainServiceInterface::class, ChainService::class);
        $this->app->bind(ChainElementsServiceInterface::class, ChainElementService::class);
        $this->app->bind(QuestionsServiceInterface::class, QuestionService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
