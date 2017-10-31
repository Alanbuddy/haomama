<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-6-22
 * Time: 下午4:49
 */

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            '*', 'App\Http\ViewComposers\WxComposer'
        );

        View::composer([
            'admin.statistics.client',
            'admin.statistics.amount',
            'admin.statistics.course',
        ],
            function ($view) {
                $view->with('showSpanForm', true);
            }
        );

        // Using Closure based composers...
        View::composer('dashboard', function ($view) {
            //
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

