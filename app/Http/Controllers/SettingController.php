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
                $arr[$category->name] = $category->hotCourseByCategory->first() ?: null;
            }
            return view('admin.setting.recommend_course', compact('arr'));
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
        if ($request->has('recommend')) {
            return $this->storeCourseRecommendationSetting($request);
        }
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

    public function storeCourseRecommendationSetting(Request $request)
    {
        $arr = $request->get('recommend');
        foreach ($arr as $k => $v) {
            $course = Course::find($v);
            if ($k == '新课速递') {
                $this->setGlobalRecommendedCourse($course);
            } else {
                $category = Term::where('name', $k)->first();
                $category->coursesByCategory()->update(['hot' => 0]);
                if ($course) {
                    $course->hot = 1;
                    $course->save();
                }
            }

        }
        if ($request->ajax()) {
            return ['success' => true];
        }
        return redirect()->route('settings.index');
    }

    public function setGlobalRecommendedCourse($course)
    {
        $setting = Setting::firstOrCreate(['key' => 'recommendedCourse']);
        $setting->value = $course ? $course->id : '';
        $setting->save();
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

    public function updateCourseRecommendation(Request $request)
    {
        $arr = $request->settins;
        if (count($arr)) {
            foreach ($arr as $k => $v) {
                if ($k == 0) {
                    updateGlobalRecommendedCourse($v);
                    continue;
                } else {
                    $course = Course::find($v);
                    $course->where('hot')->true;
                    $course->save();
                }
            }
        }
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
