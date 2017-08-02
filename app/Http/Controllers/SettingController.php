<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Setting;
use App\Models\Term;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
//        $this->middleware('role:admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *  URL /settings?key=coursel
     *      /settings?key=recommendedCourse
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ('carousel' == $request->get('key')) {
            $setting = Setting::where('key', 'carousel')->first();
            $images = json_decode($setting->value);
            return view('admin.setting.index', [
                'images' => $images,
            ]);
        } else {
            $setting = Setting::where('key', 'recommendedCourse')->first();
            $categories = Term::where('type', 'category')->with('hotCourseByCategory')->get();
            $arr = ['新课速递' => Course::find($setting->value)];
            foreach ($categories as $category) {
                $arr[$category->name] = $category->hotCourseByCategory->first()?: null;
            }
           // dd($arr);
            return view('admin.setting.recommend_course', [
                'items' => $arr
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.setting.create');
    }

    /**
     * 首页轮播图{"key":"carousel","value","{'/path/to/a.jpb,/path/to/b.jpg}"}
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Setting();
        $item->fill($request->only([
            'key',
            'value',
        ]));
//        $item->teacher_id = auth()->user()->id;
        $item->save();

        if ($request->file('cover')) {
            $folderPath = public_path('storage/setting/' . $item->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $item->cover = $cover->path;
        }
        $item->save();

        return redirect()->route('settings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function show(Setting $setting)
    {
        return view('admin.setting.show', [
            'item' => $setting,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *<
     * @param  \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function edit(Setting $setting)
    {
        return view('admin.setting.edit', [
            'item' => $setting,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Setting $setting)
    {
        $setting->fill($request->only([
            'key',
            'value',
        ]));
//        $item->teacher_id = auth()->user()->id;
        $setting->save();

        return redirect()->route('settings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Setting $setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('settings.index');
    }
}
