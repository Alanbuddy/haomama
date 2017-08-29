<?php

namespace App\Listeners;

use App\Models\Behavior;
use Carbon\Carbon;
use Illuminate\Auth\Events\Login;

class LoginEventListener
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
     * Handle the Login event.
     * every time a user login at the same day, set update_at to the last login time
     *
     * @param  Login $event
     * @return void
     */
    public function handle(Login $event)
    {
        Behavior::updateOrCreate([
            'user_id' => $event->user->id,
            'type' => 'login',
            'created_at' => date('Y-m-d')
        ], [
            'updated_at' => Carbon::now()
        ]);
    }
}
