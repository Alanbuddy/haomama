<?php

namespace App\Console\Commands;

use App\Http\Controllers\BehaviorController;
use App\Models\Behavior;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Workerman\Worker;

require_once __DIR__ . '/../../../Workerman/Autoloader.php';

class Ws extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $behaviorController;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->behaviorController = app(BehaviorController::class);
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $argv;
//        $argv[1] = $this->ask('Workman command:{start|stop|restart|reload|status|connections} ', 'start');
        $argv[1] =  'start';
        $this->info($argv[0]);
        // 创建一个Worker监听2346端口，使用websocket协议通讯
        $ws_worker = new Worker("websocket://0.0.0.0:2346");
        // 启动4个进程对外提供服务
        $ws_worker->count = 4;
        // 当收到客户端发来的数据后返回hello $data给客户端
        $ws_worker->onMessage = function ($connection, $data) {
            // 向客户端发送hello $data
            $connection->send('hello ' . $data);
            Log::debug($connection->id . " send data\n" . $data);
            $item = new Behavior();
            $item->type = 'pv';
            $data = json_decode($data);
            $connection->data = $data;
            $this->behaviorController->storePV($data, $item);
            $user = User::find($data->user);
            if ($user) $user->behaviors()->save($item);
            else $connection->data = null;
            Log::debug($item->id);
        };
        $ws_worker->onClose = function ($connection) {
            if ($connection->data)
                $this->behaviorController->storePV($connection->data);
            Log::debug($connection->id . ' close');
            Log::debug(json_encode($connection->data));
        };
        // 运行worker
        Worker::runAll();
    }
}
