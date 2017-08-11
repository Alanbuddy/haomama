<?php

namespace App\Http\Controllers;

use App\Facades\MessageFacade;
use App\Facades\Search;
use App\Http\Util\IO;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Term;
use App\Services\QR;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CourseController extends Controller
{
    use IO, SignInTrait, CourseEnrollTrait, CourseTitleTrait;

    function __construct()
    {
        $this->middleware('role:admin|operator|teacher')
            ->except(['show', 'statistics', 'enrollHandle', 'favorite', 'search', 'signIn']);
    }

    public function draftIndex(Request $request)
    {
        $items = Course::with('category')
            ->where('status', 'draft')
            ->with('teachers')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $items->withPath(route('courses.index'));
        return view('admin.course.unopen', compact('items'));
    }

    //已结课的线下课程
    public function finishedIndex(Request $request)
    {
//        dd(json_decode(Course::find(26)->schedule));
        $items = Course::with('category')
            ->where('type', 'offline')
            ->whereNotNull('schedule')
            ->where('end', '<', Carbon::now())
            ->with('teachers')
            ->with('lessons')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $items->withPath(route('courses.index'));
        return view('admin.course.end', compact('items'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->get('type');
        if ($type) {
            switch ($type) {
                case 'draft':
                    return $this->draftIndex($request);
                case 'finished':
                    return $this->finishedIndex($request);
                default:
                    break;
            }
        }
        $recommendedCourseSetting = Setting::where('key', 'recommendedCourse')->first();//dd($recommendedCourse);
        $globalRecommendedCourses = $recommendedCourseSetting
            ? Course::where('id', ($recommendedCourseSetting->value))->get()
            : null;
        $recommendedCourses = Course::where('hot', true)->get();
        $recommendedCourses = $recommendedCourses->union($globalRecommendedCourses);

        $arr = array_map(function ($v) {
            return $v->id;
        }, $recommendedCourses->all());
        $items = Course::with('category')
            ->where('status', 'publish')
            ->with('teachers')
            ->with('tags')
            ->whereNotIn('id', $arr)
            ->orderBy('id', 'desc');
//        dd($items);
        $page = $request->get('page', 1);
        $items = $this->processPage($page, $items, 10, $recommendedCourses);
        foreach ($items as $item) {
            $recommendation = '';
            if (count($globalRecommendedCourses)) {
                if ($item->id == $globalRecommendedCourses->first()->id)
                    $recommendation .= '新课速递、';
            }
            if ($item->hot) {
                $recommendation .= $item->category ? $item->category->name : '';
            }
            $item->recommendation = $recommendation;
        }
        $items->withPath(route('courses.index'));
        return view('admin.course.index', [
            'items' => $items
        ]);
    }

    public function processPage($page, $items, $pageSize, $recommendedCourse)
    {
        $count = $items->count();
        if ($page > 1) {
            $prevPageItems = $items
                ->offset(($page - 2) * $pageSize)->limit($pageSize)
                ->get()->slice($pageSize - count($recommendedCourse));
            $currPageItems = $items->paginate($pageSize);//->forPage(1, $pageSize - count($recommendedCourse));
            $items = $prevPageItems->merge($currPageItems)->splice(0, $pageSize);
        } else {
            $items = $items->paginate($pageSize)->splice(0, $pageSize - count($recommendedCourse));
            $items = $recommendedCourse->merge($items);
        }
        $items = new LengthAwarePaginator($items, $count + count($recommendedCourse), $pageSize, $page);
        return $items;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
//        return view('admin.course.create');
        $categories = Term::where('type', 'category')->get();
        $popularTags = Search::popularTags();
        return view($request->get('type') == 'offline'
            ? 'admin.course.offline'
            : 'admin.course.new', compact('categories', 'popularTags'));
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
            'category_id' => 'required|numeric',
            'name' => 'required',
            'type' => 'required',
            'minimum' => 'sometimes|required|numeric',
            'quota' => 'sometimes|numeric',
            'address' => 'sometimes',
            'titles' => 'sometimes|array',
            'original_price' => 'numeric',
        ]);
        $item = new Course();
        $item->fill($request->only([
            'name',
            'description',
            'category_id',
            'price',
            'original_price',
            'cover',
            'minimum',
            'quota',
            'address',
            'time',
            'type',
        ]));
        if ($request->has('titles'))
            $item->titles = json_encode(array_values(array_filter($request->titles)));
        if ($request->has('schedule')) {
            $schedule = $request->schedule;//schedule[2] 0"2017-08-11 07:30:00,2017-08-11 08:30:00" 1	"2017-08-12 07:30:00,2017-08-12 08:30:00"
            $this->saveSchedule($schedule, $item);
        }
        if ($request->file('cover')) {
            $folderPath = public_path('storage/course/' . $item->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $item->cover = $cover->path;
        }
        $item->status = 'draft';
        $item->save();
        if ($request->has('lessons'))
            $this->updateLessons($request, $item);
        if ($request->has('tags'))
            $this->updateTags($request, $item);
        if ($request->has('teachers'))
            $this->updateTeachers($request, $item);
        if ($request->ajax()) {
            return ['success' => true, 'data' => $item];
        }
        return redirect()->route('courses.index');
    }


    /**
     * Display the specified resource.
     *
     * @param Course $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $count = $this->hasEnrolled($course);
        $hasEnrolled = $count == 1 ? true : false;
        if ($hasEnrolled && $course->type == 'offline') {
            $order = Order::where('user_id', auth()->user()->id)
                ->where('product_id', $course->id)
                ->orderBy('id', 'desc')->first();
        }

        $count = $this->hasFavorited($course);
        $hasFavorited = $count == 1 ? true : false;

        $comments = $course->comments()
            ->with('user')
            ->with('lesson')
            ->with('votes')
            ->whereNotNull('lesson_id')
            ->orderBy('vote', 'desc')
            ->paginate(3);
//        dd($comments,$comments->lastPage());
        foreach ($comments as $comment) {
            $comment->voteCount = count($comment->votes);
            $hasVoted = false;
            foreach ($comment->votes as $vote) {
                if ($vote->user_id == auth()->user()->id)
                    $hasVoted = true;
            }
            $comment->hasVoted = $hasVoted;
        }

        if (count($comments) > 3) {
            $latestComments = $course->comments()
                ->with('user')
                ->with('lesson')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
//        dd($comments);

        $lessons = $course->lessons()
            ->withPivot('created_at')
            ->orderBy('no')
            ->get();

        if (count($lessons)) {

            list($tmp, $hasNewest) = $this->newestLesson($course, $lessons);

            foreach ($lessons as $lesson) {
                $lesson->hasAttended = (bool)Attendance::where('course_id', $course->id)//线下课程每一个课时是否签到
                ->where('lesson_id', $lesson->id)
                    ->where('user_id', auth()->user()->id)
                    ->count();
                $lesson->learnedCount = $lesson->attendances($course->id)->count();//多少人已学
                //新课程标记
                $lesson->isNewest = $hasNewest ? $lesson->id == $tmp->id : false;
            }
        }

//        dd($lessons);
        $titles = json_decode($course->titles);
        $lessons = $this->processTitles($titles, $lessons);

        //学员数
        $enrolledCount = $this->enrolledCount($course);

        //收藏次数
//        $favoritedCount = $this->favoritedCount($course);

        //推荐的课程ID集合
        $recommendedCoursesIds = Search::recommend($course)->keys()
            ->take(3)
            ->all();

        //推荐的课程
        $recommendedCourses = Course::whereIn('id', $recommendedCoursesIds)
            ->withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->with('category')//预加载课程所属分类的信息
            ->get();

        //平均评分
        //评分功能只针对课程，不针对课时打分,所以要筛选没有lesson_id的评价记录
        $avgRate = $course->comments()
            ->whereNull('lesson_id')
            ->select(DB::raw('avg(star) as avg'))
            ->first()
            ->avg;
        $avgRate = round($avgRate, 1);

        $teachers = $course->teachers()->get();
        return view('course.show',//'admin.course.show',
            compact('course',//课程信息
                'hasEnrolled',//是否已经加入（购买）课程
                'hasFavorited',//是否已经收藏课程
                'enrolledCount',//学员数
                'lessons',//课时信息
                'comments',//评论 按点赞数排序
                'latestComments',//评论 按时间倒序排序
                'recommendedCourses',//按标签推荐相关课程
                'avgRate',//平均评分
                'teachers',//老师信息
                'order'
            )
        );
    }

    //后台课程详情页面
    public function adminShow(Request $request, Course $course)
    {
        $teachers = $course->teachers()->get();
        $lessons = $course->lessons()
            ->withPivot('created_at')
            ->orderBy('no')
            ->get();
        if ($course->cover && strpos($course->cover, '/') == 0)
            $course->cover = substr($course->cover, 1);

        $categories = Term::where('type', 'category')->get();
        $popularTags = Search::popularTags();
        // dd($course);
        $recommendedCourseSetting = Setting::where('key', 'recommendedCourse')->first();//dd($recommendedCourse);
        $globalRecommendedCourses = $recommendedCourseSetting
            ? Course::where('id', ($recommendedCourseSetting->value))->get()
            : null;
        $recommendation = '';
        if (count($globalRecommendedCourses)) {
            if ($course->id == $globalRecommendedCourses->first()->id)
                $recommendation .= '新课速递 ';
        }
        if ($course->hot) {
            $recommendation .= $course->category ? $course->category->name : '';
        }
        $course->recommendation = $recommendation;
        return view($course->type == 'online'
            ? 'admin.course.show'
            : 'admin.course.offline_show', compact('course', 'teachers', 'lessons', 'categories', 'popularTags'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $lessons = $course->lessons;
        $teachers = $course->teachers;
        $tags = $course->tags;
        return view('admin.course.edit', compact('course', 'lessons', 'teachers', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Course $item
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, Course $course)
    {
        $this->validate($request, [
            'category_id' => 'required|numeric',
            'name' => 'required',
            'type' => 'required',
            'minimum' => 'sometimes|required|numeric',
            'original_price' => 'numeric',
            'quota' => 'sometimes|numeric',
            'address' => 'sometimes',
        ]);
        $item = $course;
        $item->fill($request->only([
            'name',
            'description',
            'category_id',
            'price',
            'original_price',
            'cover',
            'minimum',
            'quota',
            'address',
            'time',
            'type',
        ]));
        if ($request->has('titles'))
            $item->titles = json_encode(array_values(array_filter($request->titles)));
        if ($request->has('schedule')) {
            $schedule = $request->schedule;//schedule[2] 0"2017-08-11 07:30:00,2017-08-11 08:30:00" 1	"2017-08-12 07:30:00,2017-08-12 08:30:00"
            $this->saveSchedule($schedule, $item);
        }
        if ($request->file('cover')) {
            $folderPath = public_path('storage/course/' . $item->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $item->cover = $cover->path;
        }
        $item->status = 'draft';
        $item->save();
        if ($request->has('lessons'))
            $this->updateLessons($request, $item);
        if ($request->has('tags'))
            $this->updateTags($request, $item);
        if ($request->has('teachers'))
            $this->updateTeachers($request, $item);
        if ($request->ajax()) {
            return ['success' => true, 'data' => $item];
        }
        return redirect()->route('courses.edit', $course->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index');
    }

    public function editLessons(Request $request, Course $course)
    {
        $lessons = $course->lessons->all();
        $result = array_reduce($lessons, function ($result, $v) {
            Return $result . ',' . $v['id'];
        });
//        $lessons = (explode(',', substr($result, 1)));//example:  array:2 [ 0 => "1" 1 => "2" ]
        return view('admin.course.editLesson', [
            'item' => $course,
            'lessons' => $lessons
        ]);
    }

    public function updateLessons(Request $request, Course $course)
    {
        $arr = $request->lessons;// $arr = array_map('intval', $arr);
        $tmp = [];
        foreach ($arr as $k => $id) {
            $tmp[$id] = [
                'created_at' => '' . Carbon::now(),
                'updated_at' => '' . Carbon::now(),
                'no' => $k,
            ];
        }
        Log::info(__FILE__ . json_encode($tmp));

        try {
            $changes = $course->lessons()->sync($tmp);
            if ($changes['attached']) {//如果有新课时添加,给所属课程的学员发送站内通知
                $students = $course->students()->get();
                foreach ($students as $student) {
                    MessageFacade::send([
                        'to' => $student->id,
                        'object_id' => $course->id,
                        'object_type' => 'course',
                        'has_read' => false,//this statement here is just for readability,it can be omitted since its default value is false
                        'content' => 'Some Update',
                    ], $student->id);
                    MessageFacade::sendCourseUpdateReminder($student, $course);
                }
            }
        } catch (Exception $e) {
            return back()->withErrors('数据错误');
        }
        return redirect()->route('courses.lessons.edit', $course);
    }

    public function editTags(Request $request, Course $course)
    {
        $tags = $course->tags->all();
        return view('admin.course.editTags', [
            'item' => $course,
            'tags' => $tags
        ]);
    }

    public function updateTags(Request $request, Course $course)
    {
//        $tags = $request->tags;
//        $arr = explode(',', $tags);
        $arr = $request->tags;
        $arr = array_map('intval', $arr);
        $array = [];
        foreach ($arr as $id) {
            $array['' . $id] = ['type' => 'tag'];
        }
        try {
            $course->tags()->sync($array);
        } catch (Exception $e) {
            return back()->withErrors('数据错误');
        }
        return redirect()->route('courses.tags.edit', $course);
    }

    //课程的评论
    public function commentsIndex(Request $request, Course $course)
    {
        return $course->comments()
            ->with('user')
            ->with('lesson')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function enrollHandle(Course $course)
    {
        $user = auth()->user();
        $order = $user->orders()
            ->where('product_id', $course->id)
            ->where('status', 'paid')
            ->orderBy('id', 'desc')
            ->first();

        return $order
            ? $this->enroll($course, $user->id)
            : ['success' => false];

    }

    //收藏课程与取消收藏
    public function favorite(Course $course)
    {
        $user = auth()->user();
        $count = $course->users()
            ->withPivot('type')
            ->where('type', 'favorite')
            ->where('user_id', $user->id)
            ->count();
        if ($count == 0) {
            //收藏课程
            $course->users()->attach($user, ['type' => 'favorite', 'user_type' => 'student']);
        } else {
            //取消收藏
            DB::table('course_user')
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('type', 'favorite')
                ->delete();
        }
        return ['success' => 'true', 'message' => !$count ? 'yes' : 'no'];
    }

    /**
     * @param Course $course
     * @return mixed
     */
    public function hasEnrolled(Course $course)
    {
        $count = auth()->user()
            ->enrolledCourses()
            ->where('id', $course->id)
            ->count();
        return $count;
    }

    /**
     * @param Course $course
     * @return mixed
     */
    public function hasFavorited(Course $course)
    {
        $count = auth()->user()
            ->favoritedCourses()
            ->where('id', $course->id)
            ->count();
        return $count;
    }

    public function enrolledCount(Course $course)
    {
        $count = $course
            ->users()
            ->wherePivot('type', 'enroll')
            ->count();
        return $count;
    }

    public function favoritedCount(Course $course)
    {
        $count = $course
            ->users()
            ->wherePivot('type', 'enroll')
            ->count();
        return $count;
    }

    //我收藏的课程
    public function favoriteCourses()
    {
        $items = auth()->user()
            ->favoritedCourses()
            ->withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->paginate(10);
        return view('mine.show', ['items' => $items]);
    }

    //我加入的课程
    public function enrolledCourses()
    {
        $items = auth()->user()->enrolledCourses()
            ->withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->paginate(10);
        return view('mine.mycourse', ['items' => $items]);
    }

    //置顶与取消置顶
    public function toggleHot(Request $request, Course $course)
    {
        $course->hot = !$course->hot;
        $course->save();
        return ['success' => true];
    }

    //发布与取消发布课程
    public function togglePublish(Request $request, Course $course)
    {
        if ($course->status == 'publish') {//判断这次请求是否是下架课程
            if (!auth()->user()->hasRole('admin'))//管理员才可以下架课程
                return back();
        }
        $course->status = $course->status == 'publish' ? 'draft' : 'publish';
        $course->save();
        return ['success' => true, 'data' => $course->status];
    }

    public function statistics(Request $request)
    {
        $begin = $request->get('begin', '1');
        $items = Search::coursesStatistics()
//            ->where('courses.created_at', '>'
//                , DB::raw('date_sub(`courses`.`created_at`, INTERVAL ' . $begin . ' DAY)'))
            ->where('courses.created_at', '>', date('Y-m-d H:i:s', strtotime("today -" . $begin . " days")))
            ->join('orders', 'courses.id', '=', 'orders.product_id')
            ->select('courses.id', 'courses.name', 'courses.created_at', 'comment_count', 'users_count', 'favorite_count')
            ->addSelect(DB::raw('sum(amount) as amount'))
            ->addSelect(DB::raw('count(*) as amount'))
            ->groupBy('courses.id')
            ->paginate();
        dd($items);
    }

    public function recommend(Request $request, Course $course)
    {
        $sorted = Search::recommend($course);
        dd($sorted->all());
        dd($sorted->keys()->all());
    }

    //搜索页面
    public function search(Request $request)
    {
        //搜索结果页面
        $route = $request->route();
        if ($route->hasParameter('tag')) {
            $items = Search::coursesByTag($request->route('tag'))
                ->withCount('comments')
                ->withCount(['users' => function ($query) {
                    $query->where('type', 'enroll');
                }])
                ->with('category')->paginate(6);
            if ($request->ajax()) {
                return $items;
            }
            return view('course.edit', compact('items'));
        }
        if ($request->has('key')) {
            $items = Search::search($request->key)
                ->paginate(6);
//            dd($items);
            if ($request->ajax()) {
                return $items;
            }
            return view('course.edit', compact('items'));
        }
        if ($request->has('name'))
            return $this->searchByName($request);

        //搜索页面
        $popularTags = Search::popularTags();
        return view('course.create', compact('popularTags'));
    }

    public function adminSearch(Request $request)
    {
        if ($request->has('key')) {
            $items = Search::search($request->key)
                ->paginate(10);
            dd($items);
            foreach ($items as $item) {
                if ($item->status == 'draft') {
                    $item->status = '未开';
                } else {
                    if ($item->type == 'offline'
                        && $item->end
                        && $item->end < Carbon::now()
                    ) {
                        $item->status = '结课';
                    } else if ($item->type == 'offline'
                        && $item->begin
                        && $item->begin > Carbon::now()
                    ) {
                        $item->status = '未开';
                    } else {
                        $item->status = '正常';
                    }
                }
            }

            return view('admin.course.search', [
                'items' => $items,
                'key'=>$request->key,
            ]);
        }
        return redirect()->route('courses.index');
    }

    //后台设置推荐课程
    public function searchByName(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'category' => 'required']);
        $name = $request->name;
        $term = Term::where('name', $request->category)->first();
        if ($term) {
            $items = $term->coursesByCategory()->where('status', 'publish')
                ->where('name', 'like', '%' . $name . '%')
                ->paginate(10);
        } else {//新课速递
            $items = Course::where('name', 'like', '%' . $name . '%')
                ->paginate(10);
        }
        return $items;
    }


    /**
     * 线下课程签到
     * @param Course $course
     * @param $index
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function signIn(Course $course, $index)
    {
        $hasEnrolled = (bool)auth()->user()->enrolledCourses()->where('id', $course->id)->count();

        if ($hasEnrolled) {
            $this->recordAttendance($course, $index);
        }


        return view('mine.create', compact('hasEnrolled', 'course', 'index', 'lesson'));
    }

    /**
     * @param Course $course
     * @param $lessons
     * @return array
     */
    public function newestLesson(Course $course, $lessons)
    {
//        $lessons = $lessons->sortByDesc->created_at; //HOM
        $tmp = $lessons->sortByDesc('created_at')->first();
        $hasNewest = true;
        if (time() - strtotime($tmp->created_at) > 7 * 24 * 60 * 60) {
            $hasNewest = false;
        }
        if ($hasNewest) {
            $hasAttended = (bool)Attendance::where('course_id', $course->id)
                ->where('lesson_id', $tmp->id)
                ->where('user_id', auth()->user()->id)
                ->count();
            $hasNewest = !$hasAttended;
        }
        return array($tmp, $hasNewest);
    }

    public function updateTeachers($request, Course $course)
    {
        $this->validate($request, [
            'teachers' => 'required'
        ]);
        //TODO
//        $arr = explode(',', $request->teachers);
        $arr = $request->teachers;
        $tmp = [];
        foreach ($arr as $id) {
            $tmp[$id] = [
                'course_id' => $course->id,
                'user_type' => 'teacher',
                'type' => 'teach'
            ];
        }
        $course->teachers()->sync($tmp);
    }

    //报名信息
    public function adminStudents(Request $request, Course $course)
    {
        $items = $course->students()->paginate(10);
        foreach ($items as $student) {
            $order = Order::where('product_id', $course->id)
                ->where('user_id', $student->id)
                ->where('status', 'paid')
                ->first();
            $items->order = $order;
        }
        $items->withPath(route('admin.courses.students', $course));
        return view('admin.course.student ', compact('items', 'course'));
    }

    //课程评论
    public function adminComments(Request $request, Course $course)
    {
        $items = $course->comments()
            ->orderBy('comments.id', 'desc')
            ->with('user')
            ->paginate(10);
        $items->withPath(route('admin.courses.students', $course));
        return view('admin.course.comment', compact('items', 'course'));
    }

    /**
     * @param $schedule
     * @param $item
     */
    public function saveSchedule($schedule, $item)
    {
        $first = array_first($schedule);
        $last = array_last($schedule);
        if ($first)
            $item->begin = explode(',', $first)[0];
        if ($last)
            $item->end = explode(',', $last)[1];
        $item->schedule = json_encode($schedule);
    }

    //后台签到管理,只针对线下课程
    public function signInAdmin(Request $request, Course $course)
    {
        $lessons = json_decode($course->titles);
        $schedules = json_decode($course->schedule);
        $attendances = $this->getAttendances($request, $course);
        dd($lessons, $schedules, $attendances);
        return view('', compact('course', 'lessons'));
    }

    public function getAttendances(Request $request, Course $course)
    {
        $attendances = $course->attendances()
            ->where('lesson_index', $request->get('index', 1))//index表示第几次课
            ->get();
        return $attendances;
    }

    public function qr(Request $request)
    {
        $data = $request->url;
        QR::qr($data);
    }

}
