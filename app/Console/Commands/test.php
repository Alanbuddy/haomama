<?php

namespace App\Console\Commands;

use App\Http\Controllers\OrderController;
use App\Http\Util\Curl;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class test extends Command
{
    use Curl;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test';

    /**
     * @var Application
     */
    protected $app;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach (User::get() as $user){
            if(!$user->hasRole('admin')&&!$user->hasRole('operator')){
                $user->attachRole(Role::find(2));
            }
        }
//        MessageFacade::send)BuyCompletedMessage(User::find(1), Course::find(1));
        $str = '/var/www/baby.com/storage/app/video/phpLeB0hE';
//        $this->info(substr($str,strpos()))

//        Storage::delete('video');
//        $directory = public_path('');
//        $files = Storage::files($directory);
//        var_dump($files);
//        Storage::deleteDirectory('video');
//        $this->info(md5(uniqid(rand(), true)));

//        $this->refundOrder();
    }

    public function refundOrder()
    {
        $uuid = $this->ask('uuid');
        $this->info($uuid);

        $controller = app(OrderController::class);
        $request = app(Request::class);
        $order = Order::where('uuid', $uuid)->first();
        $result = $controller->refund($request, $order->uuid);
        var_dump($result);
    }


    public function refundAllOrder()
    {
//        $controller = $this->app->make(OrderController::class);
        $controller = app(OrderController::class);
//        $request = $this->app->make(Request::class);
        $request = app(Request::class);
        $orders = Order::get();
        foreach ($orders as $order) {
            $result = $controller->refund($request, $order->uuid);
            var_dump($result);
        }
    }

    protected function sendRequest($requestMethod, $request, $data)
    {
        $url = $request['url'];
        $ch = curl_init($url);
        if ($requestMethod == "GET") {
            $MethodLine = "GET {$request['uri']}?{$request['query']} HTTP/1/1";
        } else if ($requestMethod == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            $MethodLine = "POST {$request['uri']}?{$request['query']} HTTP/1/1";
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $header = array(
            $MethodLine,
            "HOST:{$request['host']}",
            "Content-Length:" . $request['contentLen'],
            "Content-type:application/octet-stream",
            "Accept:*/*",
            "User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.95 Safari/537.36",

        );

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // 证书
        // curl_setopt($ch,CURLOPT_CAINFO,"ca.crt");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


        $response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($response, true);
        if (!$result) {
            echo "[sendRequest] 请求发送失败，请检查URL:\n";
            echo $url . "\n";
            return $response;
        }
        return $result;
    }
}
