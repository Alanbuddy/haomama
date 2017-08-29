<?php

namespace App\Http\Controllers;

use App\Models\Behavior;
use App\Models\Lesson;
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
        $subscribersOfLast2Weeks = $this->subscribersPerWeek()->limit(2)->get();
        $subscribersOfLast2Months = $this->subscribersPerMonth()->limit(2)->get();
        $subscribersOfLast2Days = $this->subscribersPerDay()->limit(2)->get();
        $subscribersOfLastDay = $subscribersOfLast2Days->last();
        dd($subscribersOfLast2Weeks->all(), $subscribersOfLast2Months->all(),$subscribersOfLast2Days->all(),$subscribersOfLastDay);
        return view('statistics.index', compact('subscribers'));
    }

    public function subscribers()
    {
        $record = Statistic::where('type', 'subscribe')->where('created_at', date('Y-m-d'))->first();
        $count = $record ? $record->data : 0;
        return $count;
    }

    public function subscribersPerSpan($date_format){
        return Statistic::where('type', 'subscribe')
            ->select(DB::raw('DATE_FORMAT(created_at,\''.$date_format.'\') as time_span'))
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
    public function registrationPerSpan($date_format){
        return Statistic::where('type', 'registration')
            ->select(DB::raw('DATE_FORMAT(created_at,\''.$date_format.'\') as time_span'))
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
}
