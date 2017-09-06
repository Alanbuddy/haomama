<?php

namespace App\Http\Controllers;

use App\Models\Behavior;
use App\Models\Course;
use App\Models\User;
use App\Services\SimpleRouter;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if ($request->get('type') == 'pv') {
            $data = json_decode($request->data);
            //数据中有duration属性表示离开页面
            $isEnd = property_exists($data, 'duration');
            $this->storePV($data, $isEnd ? null : $item);
            $valid = !$isEnd;
        }

        Log::info("valid?{$valid}");
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
        try {
//            $this->router->dispatchToRoute($peudoRequest);

            $route = $this->router->findRoute($peudoRequest);

            $peudoRequest->setRouteResolver(function () use ($route) {
                return $route;
            });
        } catch (NotFoundHttpException $e) {
            Log::error(__FILE__ . __LINE__ . "\n" . $e->getMessage());
        }
        return $peudoRequest;
    }

    /**
     * @param $data
     *      Example {"url":"\/courses\/1","time":"2017-8-8"}
     * @param $type
     * @param $item
     */
    public function storePV($data, $item = null)
    {
        $url = $data->url; //$uri = '/courses/1?a=b';
        $time = $data->time; //$uri = '/courses/1?a=b';
        if ($item) {
            $peudoRequest = $this->peudoRequest($url);
            $route = $peudoRequest->route();
            //如果url参数错误，忽略这次请求 //throw new \Exception("uri {$url} does not exists");
            if (empty($route)) return;
            $page = '';
            Log::debug(__METHOD__ . $route->getName());
            Log::debug($route->getName()=='user.account'?'yes':'no');
            Log::debug($route->getName()=='users.show'?'yes':'no');
            switch ($route->getName()) {
                case 'index':
                    $page = '首页';
                    break;
                case 'users.show':
                    $page = '老师主页(' . User::findOrFail($route->parameter('user'))->name.')';
                    break;
                case 'courses.show':
                    $page = '课程' . Course::findOrFail($route->parameter('course'))->name;
                    break;
                case 'courses.search':
                    $page = '搜索页(关键词' . $peudoRequest->get('key') . ')';
                    break;
                case 'user.profile':
                    $page = '个人资料';
                    break;
                case 'user.account':
                    $page = '我的';
                    break;
            }
            $data->page = $page;
            $item->data = json_encode($data);
        } else {
            $user = User::findOrFail($data->user);
            $log = $user->behaviors()->where('type', 'pv')
                ->where(DB::raw('data->"$.url"'), $url)
                ->where(DB::raw('data->"$.time"'), $time)
                ->whereNull(DB::raw('data->"$.duration"'))
                ->orderBy('id', 'desc')
                ->first();
            if ($log) {
                $logData = json_decode($log->data);
                $logData->duration = gmstrftime('%H:%M:%S', time() - $logData->time);
                $log->data = json_encode($logData);
                $log->save();
            }
        }
    }
}
