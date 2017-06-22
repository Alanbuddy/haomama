<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;

class UserController extends Controller
{

    function __construct()
    {
//        $this->middleware('role:admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::paginate(10);
        return view('admin.user.index', [
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
        $item = new User();
        $item->fill($request->only([
            'name',
        ]));
        $item->save();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if ($user->hasRole('teacher')) {
            return $this->showTeacher($user);
        }
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

        $messagesCount=$user->messages()->where('has_read',false)->count();

        return view('mine.index',
            compact('user', 'enrolledCourses', 'favoritedCourses', 'onGoingCourses','messagesCount')
        );
    }

    public function showTeacher(User $user)
    {
        $courses = $user->coachingCourse()
            ->withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->with('category')//预加载课程所属分类的信息
            ->orderBy('id', 'desc')
            ->get();
        $user->description = json_decode($user->description);

        $votes = $user->votes()->get();
        $hasVoted = false;
        foreach ($votes as $vote) {
            if ($vote->user_id == auth()->user()->id)
                $hasVoted = true;
        }
        
        return view('setting.teacher',
            compact('user', 'courses','hasVoted','votes')
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
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
}
