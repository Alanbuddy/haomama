<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class test extends Command
{
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
        $str = "";
        $str .= date("Y-m-d H:i:s", time()) . ",1234\n";
        $str .= date("Y-m-d H:i:s", time()) . ",5678\n";
        file_put_contents('csv.txt', $str);
        $str = file_get_contents(base_path("csv.txt"));
        $str = chop($str);
//        $str=preg_replace('/[sS]*?$/','',$str);
        print($str);
        $arr = explode(PHP_EOL, $str);
        print_r($arr);
        $this->info($str);
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
