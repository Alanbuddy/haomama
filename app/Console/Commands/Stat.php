<?php

namespace App\Console\Commands;

use App\Http\Wechat\WxApi;
use App\Models\Behavior;
use App\Models\Order;
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
        $this->recordSubscriptionDaily();
        $this->recordRegistrationDaily();
        $this->recordActiveUsersDaily();
        $this->recordOrdersDaily();
        $this->recordIncomeDaily();
    }

    /**
     * @return array
     */
    public function getSubscribers()
    {
        $subscribers = [];
        DB::table('users')
            ->whereNotNull('openid')
            ->where('openid', '<>', '')
            ->orderBy('id')
            ->chunk(100, function ($users) use (&$subscribers) {
                $arr = [];
                foreach ($users as $user) {
                    $arr[] = ['openid' => $user->openid];
                }
                $result = WxApi::commonUserInfoBatch($arr);
                $data = json_decode($result['data']);
                if (property_exists($data, 'user_info_list')) {
                    foreach ($data->user_info_list as $item) {
                        if ($item->subscribe)
                            $subscribers[] = $item->openid;
                    }
                }

//                foreach ($users as $user) {
//                    $result = WxApi::commonUserInfo($user->openid);
////                    $this->info(property_exists(json_decode($result['data']),'subscribe')?1:0);
//                    if (property_exists(json_decode($result['data']), 'subscribe')) {
//                        $subscribers[] = $user->id;
//                        $this->info('User ' . $user->id . ' 已经关注');
//                        $this->info(json_encode($subscribers));
//                    } else {
//                        $this->info('User ' . $user->id . ' 未关注');
//                    }
//                }
            });
        return $subscribers;
    }

    /**
     * 记录截止昨天关注号关注人数
     */
    public function recordSubscriptionDaily()
    {
        $subscribers = $this->getSubscribers();
//        User::whereIn('id', $subscribers)->update(['subscribe' => true]);
        User::whereIn('openid', $subscribers)->update(['subscribe' => true]);
        Statistic::updateOrCreate([
            'type' => 'subscribe',
            'created_at' => date("Y-m-d", strtotime('today -1 day'))
        ], [
            'data' => count($subscribers)
        ]);

        $this->info(__METHOD__ . ' done');
    }

    /**
     * 记录昨天的用户注册数
     */
    public function recordRegistrationDaily()
    {
        $date = date('Y-m-d', strtotime('today -1 day'));
        $count = User::where('created_at', '>', $date)
            ->where('created_at', '<=', date('Y-m-d'))
            ->count();
        Statistic::updateOrCreate([
            'type' => 'registration',
            'created_at' => $date
        ], [
            'data' => $count
        ]);
        $this->info(__METHOD__ . ' done');
    }

    /**
     * 记录昨天的活跃用户
     */
    public function recordActiveUsersDaily()
    {
        $date = date('Y-m-d', strtotime('today -1 day'));
        $count = Behavior:: where('type', 'login')
            ->where('created_at', '>', $date)
            ->where('created_at', '<', date('Y-m-d'))
            ->count();
        Statistic::updateOrCreate([
            'type' => 'activeUser',
            'created_at' => $date
        ], [
            'data' => $count
        ]);
        $this->info(__METHOD__ . ' done');
    }

    /**
     * 记录昨天的成交次数
     */
    public function recordOrdersDaily()
    {
        $date = date('Y-m-d', strtotime('today -1 day'));
        $count = Order:: where('status', 'paid')
            ->where('created_at', '>', $date)
            ->where('created_at', '<', date('Y-m-d'))
            ->count();
        Statistic::updateOrCreate([
            'type' => 'order',
            'created_at' => $date
        ], [
            'data' => $count
        ]);
        $this->info(__METHOD__ . ' done');
    }

    /**
     * 记录昨天的收入
     */
    public function recordIncomeDaily()
    {
        $date = date('Y-m-d', strtotime('today -1 day'));
        $count = Order:: where('status', 'paid')
            ->where('created_at', '>', $date)
            ->where('created_at', '<', date('Y-m-d'))
            ->sum('wx_total_fee');
        Statistic::updateOrCreate([
            'type' => 'income',
            'created_at' => $date
        ], [
            'data' => $count
        ]);
        $this->info(__METHOD__ . ' done');
    }
}
