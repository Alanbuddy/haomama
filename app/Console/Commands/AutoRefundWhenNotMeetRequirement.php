<?php

namespace App\Console\Commands;

use App\Events\Refund;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AutoRefundWhenNotMeetRequirement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:refund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 线下课程开课前24小时,人数不够则自动退款
     * @return mixed
     */
    public function handle()
    {
        Log::debug(__METHOD__ . 'Auto refund when students amount does not meet the least requirement');
        $items = Course::where('type', 'offline')
            ->whereNotNull('minimum')
            ->get();
        Log::debug(count($items));
        foreach ($items as $course) {
            $studentsCount = $course->students()->count();
            Log::debug($studentsCount . ' ' . $course->minimum . ' id:' . $course->id . ' name:' . $course->name);
            if ($studentsCount < $course->minimum) {
                Log::debug($studentsCount . '<' . $course->minimum . ' Not Enough Students For Course' . $course->name . '(' . $course->id . ')');
                $date = date('Y-m-d H', strtotime('+2 hour'));
                if (date('Y-m-d H', strtotime($course->begin)) == $date) {
                    $orders = $course->orders()
                        ->where('status','paid')
                        ->get();
                    Log::debug('order of course'. $course->id.' count:' . count($orders));
                    foreach ($orders as $order) {
                        Log::debug('refund order:' . $order->id);
                        $this->refund($order);
                    }
                }
            }
        }
    }

    public function refund($order)
    {
        event(new Refund($order));
    }
}