<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Util\IO;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use IO;

    function __construct()
    {
        $this->middleware('role:admin')->except('profile');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('course.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function info()
    {
        phpinfo();
    }

    //后台的账号设置页面
    public function profile(Request $request)
    {
        $user = auth()->user();
        if ($request->isMethod('POST')) {
            //修改头像
            if ($request->hasFile('avatar')) {
                $avatar = $this->moveAndStore($request, 'avatar');
                $user->$avatar = $avatar;
            }

            //修改名字
            if ($request->get('name')) {
                $user->name = $request->get('name');
            }
            $user->save();
        }
        return view('admin.user.profile',compact('user'));
    }
}
