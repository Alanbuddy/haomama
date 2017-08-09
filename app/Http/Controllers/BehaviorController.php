<?php

namespace App\Http\Controllers;

use App\Models\Behavior;
use App\Services\SimpleRouter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class BehaviorController extends Controller
{
    use MakesHttpRequests;
    protected $app;
    protected $router;


    function __construct(Application $app, Router $router)
    {
        $this->app = $app;
        $this->router = $router;
        $this->middleware('role:admin')->except(['index', 'create', 'store']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Behavior::where('id', '>', '0')
            ->select('id', 'user_id', 'type')
            ->addSelect(DB::raw('data->"$.time" as time'))
            ->orderBy(DB::raw('data->"$.time"'), 'desc')
            ->paginate(10);
//        dd($items);
        return view('admin.user_behavior.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.user_behavior.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required'
        ]);
        $item = new Behavior();
        $item->fill($request->only([
            'type',
            'data',
            'lesson_id',
            'video_id'
        ]));

        $valid = true;//是否需要保存到数据库
        if ($request->get('type') == 'video.watch') {
            $valid = $this->recordVideoWatch($request);
        }

        if ($request->get('type') . contains('pv')) {
            $this->storePV($request, $item);
            if ($request->type == 'pv.end') $valid = false;
            else $item->type = 'pv';
        }

        if ($valid)
            auth()->user()->behaviors()->save($item);

        if ($request->ajax()) {
            return ['success' => $valid ? true : false];
        }

        return redirect()->route('behaviors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function show(Behavior $behavior)
    {
        return view('admin.user_behavior.show', [
            'item' => $behavior,
        ]);
    }

    //更新观看时长
    public function updateDuration(Request $request)
    {
        $record = auth()->user()->behaviors()
            ->where('lesson_id', $request->get('lesson_id'))
            ->orderBy('id', 'desc')
            ->increment('duration', $request->get('duration'));
        dd($record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Behavior $userBehavior)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function destroy(Behavior $userBehavior)
    {
        //
    }

    public function latest(Request $request)
    {
        $items = Behavior::where('id', '>', '0')
            ->select('id', 'user_id', 'type')
            ->addSelect(DB::raw('data->"$.time" as time'))
//            ->where(DB::raw('json_search(data,"one","%2%")'),'like', '%2%')
            ->paginate(10);
        dd($items);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function recordVideoWatch(Request $request)
    {
        $record = auth()->user()->behaviors()
            ->where('video_id', $request->video_id)
            ->orderBy('id', 'desc')
            ->first();
        return !($record && (time() - strtotime($record->created_at) < 10 * 60)); //10分钟内重复看一个视频只算一次观看记录
    }

    /**
     * @param $uri
     * @return Request
     */
    public function peudoRequest($uri)
    {
        $server = [];
        $method = 'GET';
        $parameters = [];
        $cookies = [];
        $files = [];
        $symfonyRequest = SymfonyRequest::create(
            $this->prepareUrlForRequest($uri), $method, $parameters,
            $cookies, $files, $server, null
        );
        $peudoRequest = Request::createFromBase($symfonyRequest);
        $this->router->dispatchToRoute($peudoRequest);
        return $peudoRequest;
    }

    /**
     * @param Request $request
     * @param $item
     */
    public function storePV(Request $request, $item)
    {
        $data = json_decode($request->data);
        $url = $data->url; //$uri = '/courses/1?a=b';
        $isEnd = explode('.', $request->type)[1] == 'end';
        if ($isEnd) {
            $log = auth()->user()->behaviors()->where('type', 'pv')
                ->where(DB::raw('data->"$.url"'), $url)
                ->whereNull(DB::raw('data->"$.duration"'))
                ->orderBy('id', 'desc')
                ->firstOrFail();
            $logData = json_decode($log->data);
            $logData->timeEnd = $data->time;
            $logData->duration = strtotime($data->time) - strtotime($logData->time);
            $log->data = json_encode($logData);
            $log->save();
        } else {
            $peudoRequest = $this->peudoRequest($url);
            $route = $peudoRequest->route();
            $page = '';
            switch ($route->getName()) {
                case 'index':
                    $page = '首页';
                    break;
                case 'courses.show':
                    $page = '课程' . $route->parameter('course')->name;
                    break;
                case 'courses.search':
                    $page = '搜索页(关键词' . $peudoRequest->get('key') . ')';
                    break;
                case 'user.profile':
                    $page = '个人资料';
                    break;
            }
            $data->page = $page;
            $item->data = json_encode($data);
        }
    }
}
