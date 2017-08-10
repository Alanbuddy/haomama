<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    function __construct()
    {
        $this->middleware('role:admin|operator')->only(['index']);
    }

    /**
     *
     * 用户列表页
     * 地址:http://localhost/users?type=operator
     * type参数代表用户在系统中的角色，根据此参数从数据库筛选用户数据
     * type参数可能值是Role表中的name字段所有取值之一(目前存在的值为'teacher','operator','admin')
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'user');
        if ($type == 'operator') {
            if (!auth()->user()->hasRole('admin')) {
                return back();
            }
        }
        if ($type != 'user') {
            $roles = array_map(function ($v) {
                return $v->name;
            }, Role::select('name')->get()->all());
            $role = Role::where('name', $type)->first();
            $items = in_array($type, $roles)
                ? $role->users()->paginate(10)
                : [];
        } else {
            $items = User::select('users.*')
                ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->whereNull('role_id')
                ->addSelect(DB::raw('wx->"$.nickname" as wx_nickname'))//没有用到
                ->paginate(10);
        }
        switch ($type) {
            case 'user':
                $view = 'admin.client.index';
                break;
            case 'teacher':
                $view = 'admin.teacher.index';
                break;
            case 'operator':
                $view = 'admin.user.index';
                break;
            default:
                $view = 'admin.client.index';
        }
        // dd($items);
        $items->withPath(route('users.index'));

        return view($view, [
            'items' => $items
        ]);
    }

    public function newOperatorCount()
    {
        $role = Role::where('name', 'operator')->first();
        $items = $role->users;
        $newOperators = [];
        foreach ($items as $item) {
            if (empty($item->status)) {
                $newOperators[] = $item;
            }
        }
        return count($newOperators);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'user');
        if ($type == 'teacher') {
            return view('admin.teacher.teacher_new');
        } elseif ($type == 'operator') {

        }
        return view('admin.user.create');
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
            'name' => 'required',
        ]);
        $item = new User();
        $this->storeBase($request, $item);
        if ($request->wantsJson()) {
            return ['success' => true, 'data' => $item];
        }
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user)
    {
        $userId = $user->id;
        $enrolledCourses = Search::enrolledCourses($userId)->get();
        $favoritedCourses = Search::favoritedCourses($userId)->get();
//        dd($favoritedCourses);
        $onGoingCourses = Search::onGoingCourses($userId)->get(); //on going offline courses that I've enrolled
        foreach ($onGoingCourses as $c) {
            $timeInfo = "";
            foreach ($c->onGoingLessons as $lesson) {
                $timeInfo .= date('m/d', strtotime($lesson->begin)) . ' ';
            }
            $c->time = $timeInfo;
        }

        //unread messages count;
        $messagesCount = $user->messages()->where('has_read', false)->count();
        return view('mine.index',
            compact('user', 'enrolledCourses', 'favoritedCourses', 'onGoingCourses', 'messagesCount')
        );
    }

    //后台用户管理
    public function showAdmin(Request $request, User $user)
    {
        if ('teacher' == $request->get('type')) {
            return $this->showTeacher($user);
//            return view('admin.teacher.teacher_show', ['user' => $user]);
        }
        $items = User::paginate();
        return view('admin.client.show', compact('items'));
    }


    public function showTeacher(User $user)
    {
        $user->description = json_decode($user->description);
        $courses = $user->coachingCourse()
            ->withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->with('category')//预加载课程所属分类的信息
            ->orderBy('id', 'desc')
            ->get();
        foreach ($courses as $course) {
            $course->sale = $course->orders()->sum('wx_total_fee');
        }
        return view('admin.teacher.teacher_show',
            compact('user', 'courses')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = $user->roles;
        return view('admin.user.edit', [
            'item' => $user,
            'roles' => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (!$request->has('roles')) {
            $this->teacherUpdate($request, $user);
            return ['success' => true];
        }
        $roles = $request->roles;
        $arr = explode(',', $roles);
        $arr = array_map('intval', $arr);
        try {
            $user->roles()->sync($arr);
        } catch (Exception $e) {
            return back()->withErrors('数据错误');
        }
        return redirect()->route('users.edit', $user);
    }

    public function teacherUpdate(Request $request, User $user)
    {
        $this->storeBase($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $canDelete = $user->coachingCourse()->count() == 0;
        if ($canDelete)
            $user->delete();
        return ['success' => $canDelete];
    }

    public function profile(Request $request)
    {
        $user = auth()->user();
        if ($request->isMethod('POST')) {
            if ($request->has('parenthood')) {
                $user->parenthood = $request->parenthood;
            }
            if ($request->has('phone')) {
                $user->phone = $request->phone;
            }
            if ($request->has('baby')) {
                $user->baby = $request->baby;
            }
            $user->save();
        }
        $user->baby = json_decode($user->baby);
        if ($request->ajax()) {
            return ['success' => true];
        }
        return view('setting.index', ['user' => $user]);
    }

    //老师主页点赞功能
    public function vote(Request $request, User $user)
    {
        $vote = Vote::where('teacher_id', $user->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        $hasVoted = (bool)$vote;
        if ($vote) {
            $vote->delete();
        } else {
            $vote = new Vote();
            $vote->fill([
                'teacher_id' => $user->id,
                'user_id' => auth()->user()->id
            ]);
            $vote->save();
        }

        return ['success' => true, 'message' => !$hasVoted ? 'yes' : 'no'];
    }

    //后台人员管理-关闭
    public function disable(Request $request, User $user)
    {
        $user->status = 'disabled';
        $user->save();
        return ['success' => true];
    }

    //后台人员管理-开通
    public function enable(Request $request, User $user)
    {
        $user->status = 'enabled';
        $user->save();
        return ['success' => true];
    }

    //搜索讲师 根据名字或手机号
    public function search(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $name = $request->name;
        $role = Role::where('name', 'teacher')->first();
        $items = $role->users()
            ->where('name', 'like', '%' . $name . '%')
            ->orWhere('phone', 'like', '%' . $name . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return $items;
    }

    /**
     * @param Request $request
     * @param $item
     */
    public function storeBase(Request $request, User $item)
    {
        $item->fill($request->only([
            'name',
            'email',
            'phone',
            'avatar',
            'description',
        ]));

        if ('teacher' == $request->get('type')) {
            $item->password = bcrypt('123');
            $item->save();
            $role = Role::where('name', 'teacher')->first();
            $item->attachRole($role);
        }
        $item->save();
    }

    //老师的课程
    public function coursesOfTeacher(Request $request, User $user)
    {
        $items = $user->coachingCourse()->withCount('orders')
            ->with('category')
            ->addSelect(DB::raw('(select sum(orders.wx_total_fee) from `orders` where `orders`.`product_id` = `courses`.`id`) as `total_income`'))
//            ->orderBy('star', 'desc')
            ->paginate(10);

        $totalIncome = $user->coachingCourse()
            ->join('orders', 'orders.product_id', 'courses.id')
            ->sum('orders.wx_total_fee');

//        $coachingCourse= $user->coachingCourse;
//        $courseIdArr = array_map(function ($v) {
//            return $v->id;
//        }, $coachingCourse->all());

//        $studentsCount = Course::whereIn('id', $courseIdArr)
//            ->join('course_user', 'course_user.course_id', 'courses.id')
//            ->where('course_user.user_type', 'student')
//            ->where('course_user.type', 'enroll')
//            ->count();

        $ordersCount = $user->coachingCourse()
            ->join('orders', 'orders.product_id', 'courses.id')
            ->count();

//         dd($items->all(), $totalIncome,$courseIdArr,$ordersCount);
        return view('admin.teacher.teacher_course', compact('user', 'items', 'totalIncome', 'ordersCount'));
    }

    //用户访问记录
    public function log(Request $request, User $user)
    {
        $items = $user->behaviors()->where('type', 'pv')
            ->paginate(10);
        return view('admin.client.show', compact('user', 'items'));
    }

    //后台：用户订单记录
    public function order(Request $request, User $user)
    {
        $items = $user->orders()
            ->with('course')
            ->paginate(10);
        return view('admin.client.purchase', compact('user', 'items'));

    }

    //后台：用户线下课程出勤记录
    //http://baby.com/users/1/courses/24/attendance
    //返回值
    //array:3 [▼
    //0 => true
    //1 => false
    //2 => false
    //]
    public function attendance(Request $request, User $user, Course $course)
    {
        $lessons = $course->titles ? json_decode($course->titles) : [];
        $attendances = $user->attendances()
            ->where('course_id', $course->id)
            ->get();
        if ($lessons && $attendances->count()) {
            foreach ($lessons as $k => $v) {
                $hasAttended = $attendances->where('lesson_index', $k + 1)->count();
                $lessons[$k] = $hasAttended ? true : false;
            }
        }
        dd($lessons);
    }
}
