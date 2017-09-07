<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class refund extends Command
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
        $uuid = $this->ask('uuid');
        $this->info($uuid);

        $order = Order::where('uuid', $uuid)->first();
        event(new Refund($order));
    }
}
