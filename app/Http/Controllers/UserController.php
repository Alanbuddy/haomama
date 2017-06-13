<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $enrolledCourses = $user->enrolledCourses();
        $favoritedCourses = $user->favoritedCourses();
        $onGoingCourses = $user->onGoingCourses();
        return view('mine.index',
            compact('user', 'enrolledCourses', 'favoritedCourses','onGoingCourses')
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
}
