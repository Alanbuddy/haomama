<?php

namespace App\Console\Commands;

use App\Http\Wechat\WxApi;
use App\Models\User;
use App\Statistic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Stat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stat:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '统计关注用户';

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
        $subscribers = [];
        DB::table('users')
            ->whereNotNull('openid')
            ->where('openid','<>','')
            ->orderBy('id')
            ->chunk(100, function ($users) use (&$subscribers) {
                $arr = [];
                foreach ($users as $user) {
                    $arr[] = ['openid' => $user->openid];
                }
                $result = WxApi::commonUserInfoBatch($arr);
                dd($result);
                foreach ($users as $user) {
                    $result = WxApi::commonUserInfo($user->openid);
//                    $this->info(property_exists(json_decode($result['data']),'subscribe')?1:0);
                    if (property_exists(json_decode($result['data']), 'subscribe')) {
                        $subscribers[] = $user->id;
                        $this->info('User ' . $user->id . ' 已经关注');
                        $this->info(json_encode($subscribers));
                    } else {
                        $this->info('User ' . $user->id . ' 未关注');
                    }
                }
            });
        User::whereIn('id', $subscribers)->update(['subscribe' => true]);
        Statistic::firstOrCreate(['type' => 'subscriber',
            'data' => count($subscribers),
            'created_at' => date("Y-m-d")
        ]);
        $this->info('done');
    }
}
