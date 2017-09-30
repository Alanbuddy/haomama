<?php

namespace App\Listeners;

use App\Events\Refund;
use App\Facades\MessageFacade;
use App\Models\Course;
use App\Models\User;

class RefundEventListener
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
     * @param  Refund $event
     * @return void
     */
    public function handle(Refund $event)
    {
        $order = $event->order;
        $order->status = 'refunded';
        $order->save();
        $course = Course::findOrFail($order->product_id);
        $course->students()->detach($order->user_id);//把学员退出课程
        MessageFacade::sendRefundCompletedMessage(User::find($order->user_id), $course);
    }
}
