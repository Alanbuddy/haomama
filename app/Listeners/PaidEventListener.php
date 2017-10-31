<?php

namespace App\Listeners;

use App\Events\PaidEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaidEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaidEvent  $event
     * @return void
     */
    public function handle(PaidEvent $event)
    {
        //
    }
}
