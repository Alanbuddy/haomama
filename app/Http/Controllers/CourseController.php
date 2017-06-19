<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Http\Util\IO;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Lesson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use IO;

    function __construct()
    {
        $this->middleware('role:admin')->except(['index', 'show', 'statistics']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Course::where('id', '>', '0')
            ->paginate(10);
        return view('admin.course.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.course.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Course();
        $item->fill($request->only([
            'name',
            'description',
            'price',
        ]));
//        $item->teacher_id = auth()->user()->id;
        $ids = $request->teacherId;
        $arr = explode(',', $ids);
        $arr = array_map('intval', $arr);
//        dd($arr);
        try {
            $item->teachers()->sync($arr);
        } catch (Exception $e) {
            return back()->withErrors('数据错误');
        }
        $item->save();

        if ($request->file('cover')) {
            $folderPath = public_path('storage/course/' . $item->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $item->cover = $cover->path;
        }
        $item->save();

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

        $count = $this->hasFavorited($course);

        $hasFavorited = $count == 1 ? true : false;
        $comments = $course->comments()->paginate(10);
        $lessons = $course->lessons()
            ->paginate(10);
        foreach ($lessons as $lesson) {
            $lesson->hasAttended = (bool)Attendance::where('course_id', $course->id)
                ->where('lesson_id', $lesson->id)
                ->where('user_id', auth()->user()->id)
                ->count();
        }
        $enrolledCount = $this->enrolledCount($course);
        $favoritedCount = $this->favoritedCount($course);
        $recommendedCourses = Search::recommend($course)->keys()->take(3)->all();
        return view('course.show',//'admin.course.show',
            compact('course',//课程信息
                'hasEnrolled',//是否已经加入（购买）课程
                'hasFavorited',//是否已经收藏课程
                'enrolledCount',//学员数
                'lessons',//课时信息
                'comments',//评论
                'recommendedCourses'//按标签推荐相关课程
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.course.edit', [
            'item' => $course,
        ]);
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
        $course->fill($request->only([
            'name',
            'description',
            'price',
            'begin',
            'end',
            'category_id',
        ]));
//        $course->teacher_id = auth()->user()->id;

        if ($request->file('cover')) {
            $folderPath = public_path('storage/course/' . $course->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $course->cover = $cover->path;
        }
        $course->update();

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
        $lessons = $request->lessons;
        $arr = explode(',', $lessons);
        $arr = array_map('intval', $arr);
//        dd($arr);
        try {
            $course->lessons()->sync($arr);
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
        $lessons = $request->lessons;
        $arr = explode(',', $lessons);
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
        return $course->comments()->get();
    }

    //加入课程
    public function enroll(Course $course)
    {
        $user = auth()->user();
        $user_type = $user->hasRole('teacher') ? 'teacher' : 'student';
//        $course->users()->attach(auth()->user(), ['type' => $type]);
        $changed = $course->users()->syncWithoutDetaching($user, ['user_type' => $user_type]);
        return ['success' => 'true', 'changed' => $changed];
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
            $course->users()->attach($user, ['type' => 'favorite']);
        } else {
            //取消收藏
            DB::table('course_user')
                ->where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('type', 'favorite')
                ->delete();
        }
        return ['success' => 'true'];
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
            $items = Search::coursesByTag($request->route('tag'));
            return view('course.edit', [
                'items' => $items,
            ]);
        }
        if ($request->has('key')) {
            $items = Search::search($request->key)
                ->paginate(6);
//            dd($items);
            return view('course.edit', [
                'items' => $items,
            ]);
        }

        //搜索页面
        $popularTags = Search::popularTags();
        return view('course.create', compact('popularTags'));
    }


    /**
     * 线下课程签到
     * @param Request $request
     * @param Course $course
     * @param Lesson $lesson
     * @return \Illuminate\Http\RedirectResponse|string
     */
    public function signIn(Request $request, Course $course, Lesson $lesson)
    {
        $hasAttended = (bool)Attendance::where('course_id', $course->id)
            ->where('lesson_id', $lesson->id)
            ->where('user_id', auth()->user()->id)
            ->count();
        if (!$hasAttended) {
            $attendance = new Attendance();
            $attendance->fill([
                'user_id' => auth()->user()->id,
                'course_id' => $request->route('course')->id,
                'lesson_id' => $request->route('lesson')->id,
            ]);
            $attendance->save();
        }
        return 'success';
        return back();
    }
}
