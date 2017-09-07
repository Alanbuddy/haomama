<?php

namespace App\Console\Commands;

use App\Events\Refund;
use App\Models\Course;
use Illuminate\Console\Command;

class AutoRefundWhenNotMeetRequirement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refund';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(__METHOD__ . 'Auto refund when students amount does not meet the least requirement');
        $items = Course::where('type', 'offline')
            ->whereNotNull('quota')
            ->get();
        $this->info(count($items));
        foreach ($items as $course) {
            $studentsCount = $course->students()->count();
            $this->info($studentsCount . ' ' . $course->minimum . ' id:' . $course->id . ' name:' . $course->name);
            if ($studentsCount < $course->minimum) {
                $this->info($studentsCount . '<' . $course->minimum . ' Not Enough Students For Course' . $course->name . '(' . $course->id . ')');
                $date = date('Y-m-d H', strtotime('+2 hour'));
                if (date('Y-m-d H', strtotime($course->begin)) == $date) {
                    $orders = $course->orders();
                    foreach ($orders as $order) {
                        $this->info('refund order:' . $order->id);
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
