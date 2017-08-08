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
    protected $simpleRouter;


    function __construct(Application $app, Router $router,SimpleRouter $simpleRouter)
    {
        $this->app = $app;
        $this->router = $router;
        $this->simpleRouter = $simpleRouter;
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
        $server = [];
        $uri = '/courses/1?a=b';
        $this->t($uri);
        $method = 'GET';
        $parameters = [];
        $cookies = [];
        $files = [];
        $symfonyRequest = SymfonyRequest::create(
            $this->prepareUrlForRequest($uri), $method, $parameters,
            $cookies, $files,  $server, null
        );
        $request = Request::createFromBase($symfonyRequest);
        $this->dispatchToRoute($request);
        dd($request->route('course'), $server, $this->call('GET', $uri, [], [], [], $server));
        return view('admin.user_behavior.create');
    }

    public function t($uri)
    {
        $router=$this->simpleRouter;
        $route = $router->getRoute($uri);
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

        $valid = true;
        if ($request->get('type') == 'video.watch') {
            $valid = $this->recordVideoWatch($request);
        }

        if ($request->get('type') . contains('pv')) {
            $routeName = $request->route()->getName();
            switch ($routeName) {
                case 'courses.show':
                    $page = '课程页面';
                    break;
            }
            $item->data = ['url' => $request->route()];
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
}
