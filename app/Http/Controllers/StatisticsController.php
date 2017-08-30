<?php

namespace App\Http\Controllers;

use App\Models\Behavior;
use App\Models\Lesson;
use App\Models\Order;
use App\Models\User;
use App\Statistic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth', 'role:admin|operator|teacher']);
    }

    public function index(Request $request)
    {
        $subscribers = $this->subscribers();
//        dd($subscribers);
        //关注人数相关
        $subscribersOfLast2Weeks = $this->subscribersPerWeek()->limit(2)->get();
        $subscribersOfLast2Months = $this->subscribersPerMonth()->limit(2)->get();
        $subscribersOfLast2Days = $this->subscribersPerDay()->limit(2)->get();
        $subscribersOfLastDay = $subscribersOfLast2Days->first();
        $compareWeek = (count($subscribersOfLast2Weeks) == 2 && $subscribersOfLast2Weeks[1]->total != 0) ? $subscribersOfLast2Weeks[0]->total / $subscribersOfLast2Weeks[1]->total * 100 : 0;
        $compareMonth = (count($subscribersOfLast2Months) == 2 && $subscribersOfLast2Months[1]->total != 0) ? $subscribersOfLast2Months[0]->total / $subscribersOfLast2Months[1]->total * 100 : 0;
        $compareDay = (count($subscribersOfLast2Days) == 2 && $subscribersOfLast2Days[1]->total != 0) ? $subscribersOfLast2Days[0]->total / $subscribersOfLast2Days[1]->total * 100 : 0;
        $subscriberStat = compact('subscribersOfLastDay', 'compareDay', 'compareWeek', 'compareMonth');

//        dd($subscribersOfLast2Weeks->all(), $subscribersOfLast2Months->all(), $subscribersOfLast2Days->all(),$subscriberStat);

        //注册人数相关
        $registrationsOfLast2Weeks = $this->registrationPerSpan('%Y%u')->limit(2)->get();
        $registrationsOfLast2Months = $this->registrationPerSpan('%Y%m')->limit(2)->get();
        $registrationsOfLast2Days = $this->registrationPerSpan('%Y%m%d')->limit(2)->get();
        $registrationsOfLastDay = $registrationsOfLast2Days->first();
        $compareWeek = (count($registrationsOfLast2Weeks) == 2 && $registrationsOfLast2Weeks[1]->total != 0) ? $registrationsOfLast2Weeks[0]->total / $registrationsOfLast2Weeks[1]->total * 100 : 0;
        $compareMonth = (count($registrationsOfLast2Months) == 2 && $registrationsOfLast2Months[1]->total != 0) ? $registrationsOfLast2Months[0]->total / $registrationsOfLast2Months[1]->total * 100 : 0;
        $compareDay = (count($registrationsOfLast2Days) == 2 && $registrationsOfLast2Days[1]->total != 0) ? $registrationsOfLast2Days[0]->total / $registrationsOfLast2Days[1]->total * 100 : 0;
        $registrationStat = compact('registrationsOfLastDay', 'compareDay', 'compareWeek', 'compareMonth');
//        dd($registrationsOfLast2Weeks->all(), $registrationsOfLast2Months->all(), $registrationsOfLast2Days->all(), $registrationsOfLastDay,$registrationStat);

        //活跃用户统计
        $activeUsersOfLast2Weeks = $this->activeUsersPerSpan('%Y%u')->limit(2)->get();
        $activeUsersOfLast2Months = $this->activeUsersPerSpan('%Y%m')->limit(2)->get();
        $activeUsersOfLast2Days = $this->activeUsersPerSpan('%Y%m%d')->limit(2)->get();
        $activeUsersOfLastDay = $activeUsersOfLast2Days->first();
        $compareWeek = (count($activeUsersOfLast2Weeks) == 2 && $activeUsersOfLast2Weeks[1]->total != 0) ? $activeUsersOfLast2Weeks[0]->total / $activeUsersOfLast2Weeks[1]->total * 100 : 0;
        $compareMonth = (count($activeUsersOfLast2Months) == 2 && $activeUsersOfLast2Months[1]->total != 0) ? $activeUsersOfLast2Months[0]->total / $activeUsersOfLast2Months[1]->total * 100 : 0;
        $compareDay = (count($activeUsersOfLast2Days) == 2 && $activeUsersOfLast2Days[1]->total) ? $activeUsersOfLast2Days[0]->total / $activeUsersOfLast2Days[1]->total * 100 : 0;
        $activeUserStat = compact('activeUsersOfLastDay', 'compareDay', 'compareWeek', 'compareMonth');
//        dd($activeUsersOfLast2Weeks->all(), $activeUsersOfLast2Months->all(), $activeUsersOfLast2Days->all(), $activeUsersOfLastDay,$activeUserStat);

        //总用户
        $usersCount = $this->usersCount('-1 day');
        $usersCountDayAgo = $this->usersCount('-2 day');
        $usersCountWeekAgo = $this->usersCount('-8 day');
        $usersCountMonthAgo = $this->usersCount('-1 month');
        $compareDay = $usersCountDayAgo != 0 ? $usersCount / $usersCountDayAgo : 0;
        $compareWeek = $usersCountWeekAgo != 0 ? $usersCount / $usersCountWeekAgo : 0;
        $compareMonth = $usersCountMonthAgo != 0 ? $usersCount / $usersCountMonthAgo : 0;
        $usersCountStat = compact('usersCount', 'compareDay', 'compareWeek', 'compareMonth');
//        dd($usersCount, $usersCountDayAgo, $usersCountWeekAgo, $usersCountMonthAgo, $usersCountStat, $activeUserStat, $subscriberStat, $registrationStat);

        //总收入
        $income = $this->income('-1 day');
        $incomeDayAgo = $this->income('-2 day');
        $incomeWeekAgo = $this->income('-8 day');
        $incomeMonthAgo = $this->income('-1 month');
        $compareDay = $incomeDayAgo != 0 ? $income / $incomeDayAgo : 0;
        $compareWeek = $incomeWeekAgo != 0 ? $income / $incomeWeekAgo : 0;
        $compareMonth = $incomeMonthAgo != 0 ? $income / $incomeMonthAgo : 0;
        $incomeStat = compact('income', 'compareDay', 'compareWeek', 'compareMonth');
//        dd($income, $incomeDayAgo, $incomeWeekAgo, $incomeMonthAgo, $incomeStat);

        //新增收入
        $incomeOfLast2Weeks = $this->incomePerSpan('%Y%u')->limit(2)->get();
        $incomeOfLast2Months = $this->incomePerSpan('%Y%m')->limit(2)->get();
        $incomeOfLast2Days = $this->incomePerSpan('%Y%m%d')->limit(2)->get();
        $incomeOfLastDay = $incomeOfLast2Days->first()->total;
        $compareWeek = (count($incomeOfLast2Weeks) == 2 && $incomeOfLast2Weeks[1]->total != 0) ? $incomeOfLast2Weeks[0]->total / $incomeOfLast2Weeks[1]->total * 100 : 0;
        $compareMonth = (count($incomeOfLast2Months) == 2 && $incomeOfLast2Months[1]->total != 0) ? $incomeOfLast2Months[0]->total / $incomeOfLast2Months[1]->total * 100 : 0;
        $compareDay = (count($incomeOfLast2Days) == 2 && $incomeOfLast2Days[1]->total != 0) ? $incomeOfLast2Days[0]->total / $incomeOfLast2Days[1]->total * 100 : 0;
        $incomeStat = compact('incomeOfLastDay', 'compareDay', 'compareWeek', 'compareMonth');
//        dd($incomeOfLast2Weeks->all(), $incomeOfLast2Months->all(), $incomeOfLast2Days->all(), $incomeOfLastDay, $incomeStat);

        //付费人数/报名人数
        $ordersOfLast2Weeks = $this->orderPerSpan('%Y%u')->limit(2)->get();
        $ordersOfLast2Months = $this->orderPerSpan('%Y%m')->limit(2)->get();
        $ordersOfLast2Days = $this->orderPerSpan('%Y%m%d')->limit(2)->get();
        $ordersOfLastDay = $ordersOfLast2Days->first()->total;
        $compareWeek = (count($ordersOfLast2Weeks) == 2 && $ordersOfLast2Weeks[1]->total != 0) ? $ordersOfLast2Weeks[0]->total / $ordersOfLast2Weeks[1]->total * 100 : 0;
        $compareMonth = (count($ordersOfLast2Months) == 2 && $ordersOfLast2Months[1]->total != 0) ? $ordersOfLast2Months[0]->total / $ordersOfLast2Months[1]->total * 100 : 0;
        $compareDay = (count($ordersOfLast2Days) == 2 && $ordersOfLast2Days[1]->total != 0) ? $ordersOfLast2Days[0]->total / $ordersOfLast2Days[1]->total * 100 : 0;
        $orderStat = compact('ordersOfLastDay', 'compareDay', 'compareWeek', 'compareMonth');
//        dd($ordersOfLast2Weeks->all(), $ordersOfLast2Months->all(), $ordersOfLast2Days->all(), $ordersOfLastDay,$orderStat);


        //用户地区分布
        $userLocationDistrubution=$this->userLocationDistrubution();
        dd($userLocationDistrubution);

        return view('statistics.index', compact('subscribers'));
    }

    public function activeUsersPerSpan($date_format)
    {
        return Statistic::where('type', 'login')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('sum(cast(data as unsigned)) as total'))
            ->addSelect(DB::raw('sum(data)'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }

    public function subscribers()
    {
        $record = Statistic::where('type', 'subscribe')->where('created_at', date('Y-m-d'))->first();
        $count = $record ? $record->data : 0;
        return $count;
    }

    public function subscribersPerSpan($date_format)
    {
        return Statistic::where('type', 'subscribe')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('sum(cast(data as unsigned)) as total'))
            ->addSelect(DB::raw('sum(data)'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }

    public function subscribersPerDay()
    {
//        ->select(DB::raw('DATE_FORMAT(created_at,\'%Y%m%d\') as time_span'))
        return $this->subscribersPerSpan('%Y%m%d');
    }

    public function subscribersPerWeek()
    {
        return $this->subscribersPerSpan('%Y%u');
    }

    public function subscribersPerMonth()
    {
        return $this->subscribersPerSpan('%Y%m');
    }

    public function watchStatistics(Request $request)
    {
        $begin = $request->begin;
        $end = $request->begin;
    }

//    统计课时观看情况列表页
    public function lessonsStatistics(Request $request)
    {
        $data = Lesson::join('behaviors', 'behaviors.lesson_id', 'lessons.id')
            ->where('behaviors.type', 'video.watch')
            ->select('lessons.*')
            ->addSelect(DB::raw('count(distinct(behaviors.user_id)) as unique_visitor_count'))//学习人数
            ->addSelect(DB::raw('sum(behaviors.duration) as watch_duration'))//学习总时长
            ->addSelect(DB::raw('count(behaviors.user_id) as watch_times'))//学习次数
            ->groupBy('lessons.id')
            ->get();
        dd($data->all());
    }

    public function registrationPerSpan($date_format)
    {
        return Statistic::where('type', 'registration')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('sum(cast(data as unsigned)) as total'))
            ->addSelect(DB::raw('sum(data)'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }

//    统计课时观看情况详情页
    public function lessonStatistics(Request $request, Lesson $lesson)
    {
        $items = Behavior::select('id', 'user_id', 'type')
            ->addSelect(DB::raw('data->"$.time" as time'))
//            ->where(DB::raw('data->"$.video_id"'), $video->id)
            ->where(DB::raw('video_id'), $lesson->video_id)
            ->where('type', 'video.drag.begin')
            ->orWhere('type', 'video.drag.end')
            ->get();

        $dragBegin = $items->where('type', 'video.drag.begin')->all();
//        dd($dragBegin);
        $dragEnd = $items->where('type', 'video.drag.end')->all();
        return compact('dragBegin', 'dragEnd');
        dd($data->all());
    }

    //总用户
    public function usersCount($offset = null)
    {
        $query = User::whereNotNull('openid');
        if ($offset) $query->where('created_at', '<', date('Y-m-d H:i:s', strtotime('today ' . $offset)));
        return $query->count();
    }

    //总收入
    public function income($offset = null)
    {
        $query = Order::where('status', 'paid');
        if ($offset) $query->where('created_at', '<', date('Y-m-d H:i:s', strtotime('today ' . $offset)));
        return $query->sum('wx_total_fee');
    }

    public function orderPerSpan($date_format)
    {
        return Statistic::where('type', 'order')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('sum(cast(data as unsigned)) as total'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }

    public function incomePerSpan($date_format)
    {
        return Statistic::where('type', 'income')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('sum(cast(data as unsigned)) as total'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }

    public function userLocationDistrubution()
    {
        return User::whereNotNull('wx')
            ->select(DB::raw('wx->"$.province" as province'))
            ->addSelect('province')
            ->addSelect(DB::raw('count(\'id\')'))
            ->groupBy('province')
            ->get();
    }
}

