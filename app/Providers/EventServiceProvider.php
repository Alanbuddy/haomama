<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\PaidEvent' => [
            'App\Listeners\PaidEventListener',
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LoginEventListener',
        ],
        'App\Events\Refund' => [
            'App\Listeners\RefundEventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
