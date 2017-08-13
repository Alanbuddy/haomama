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
    public function index(Request $request)
    {
        if($request->isMethod('post')){
            $request->flash();
            $code='<?php '.$request->get('code');
            ob_start();
            //require $directory.$codeFileName;
            try{
                eval($request->get('code'));
            }catch(\Exception $e){
                echo $e->getMessage(); //echo $e;
            }
            $ret=ob_get_contents();
            ob_end_clean();
            return view('admin.debug',[
            ]);

        }
        return view('admin.index');
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
            if ($request->has('avatar')
                && preg_match('/^(data:\s*image\/(\w+);base64,)/', $request->get('avatar'), $result)
            ) {
                //保存base64字符串为图片 //匹配出图片的格式
                $suffix = $result[2];
                $avatar = "images/" . time() . ".{$suffix}";
                file_put_contents($avatar, base64_decode(str_replace($result[1], '', $request->get('avatar'))));
                $user->avatar = $avatar;
            }

            //修改名字
            if ($request->has('name')) {
                $user->name = $request->get('name');
            }
            $user->save();
        }
        if ($request->ajax()) {
            return ['success' => true];
        }
        return view('admin.user.profile', compact('user'));
    }
}
