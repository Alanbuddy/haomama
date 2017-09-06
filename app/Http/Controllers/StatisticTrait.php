<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Statistic;
use Illuminate\Support\Facades\DB;

trait StatisticTrait
{
    public function registrationPerSpan($date_format)
    {
        return Statistic::where('type', 'registration')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('sum(cast(data as unsigned)) as total'))
//            ->addSelect(DB::raw('sum(data)'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }

    public function subscribersPerSpan($date_format)
    {
        return Statistic::where('type', 'subscribe')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('max(cast(data as unsigned)) as total'))
//            ->addSelect(DB::raw('sum(data)'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
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

    public function subscribers()
    {
        $record = Statistic::where('type', 'subscribe')->where('created_at', date('Y-m-d'))->first();
        $count = $record ? $record->data : 0;
        return $count;
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

    //总用户
    public function usersCount($offset = null)
    {
        $query = User::whereNotNull('openid');
        if ($offset) $query->where('created_at', '<', date('Y-m-d H:i:s', strtotime('today ' . $offset)));
        return $query->count();
    }

    public function usersCountPerSpan($date_format)
    {
        return Statistic::where('type', 'userCount')
            ->select(DB::raw('DATE_FORMAT(created_at,\'' . $date_format . '\') as time_span'))
            ->addSelect(DB::raw('max(data) as total'))
            ->orderBy('time_span', 'desc')
            ->groupBy('time_span');
    }
}
