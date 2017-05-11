<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Util\IO;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use IO;

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
        return view('admin.course.show', [
            'item' => $course,
        ]);
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
}
