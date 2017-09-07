<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderController;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

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
        $items = Course::where('type', 'offline')
            ->whereNotNull('quota')
            ->get();
        $this->info(count($items));
        foreach ($items as $course) {
            $studentsCount = $course->students()->count();
            if ($studentsCount < $course->minimum) {
                $this->info($studentsCount.'<'.$course->minimum.' Not Enough Students For Course' . $course->name . '(' . $course->id . ')');
            }
        }
    }

    public function refund()
    {
        $controller = app(OrderController::class);
        $request = app(Request::class);
        $order = Order::where('uuid', $uuid)->first();
        $result = $controller->refund($request, $order->uuid);
    }
}
