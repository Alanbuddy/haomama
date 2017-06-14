<?php

namespace App\Providers;

use App\Services\SearchService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        监听查询事件
        DB::listen(function ($query) {
            Log::info( $query->sql);
            Log::info( $query->time);
            Log::info( $query->bindings);
        });
        $this->app->resolving(SearchService::class, function ($api, $app) {
            Log::info(' 解析「SearchSearvice」类型的对象时调用');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
