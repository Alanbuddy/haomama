<?php

namespace App\Console\Commands;

use App\Http\Controllers\CourseEnrollTrait;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Console\Command;

class enroll extends Command
{
    use CourseEnrollTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enroll';

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
        $course_id = $this->ask('course id');
        $course = Course::find($course_id);
        $user_id = $this->ask("user id");
        $result = $this->enroll($course, $user_id);
        $this->info(json_encode($result));
        $order = new Order();
        $order->fill([
            'title' => $course->name,
            'user_id' => $user_id,
            'product_id' => $course->id,
            'status' => 'paid',
            'amount' => $course->price?:$course->original_price,
            'uuid'=>'test'
        ]);
        $order->save();
    }
}
