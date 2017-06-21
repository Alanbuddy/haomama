<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Models\Lession;
use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    function __construct()
    {
        $this->middleware('role:admin')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Lesson::where('id', '>', '0')
            ->paginate(10);
        return view('admin.lesson.index', [
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
        return view('admin.lesson.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Lesson();
        $item->fill($request->only([
            'name',
            'video_id',
            'begin',
            'end',
        ]));
//        $item->teacher_id = auth()->user()->id;
        $item->save();

        if ($request->file('cover')) {
            $folderPath = public_path('storage/lesson/' . $item->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $item->cover = $cover->path;
        }
        $item->save();

        return redirect()->route('lessons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        return view('setting.lesson', [
            'item' => $lesson,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        return view('admin.lesson.edit', [
            'item' => $lesson,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        $lesson->fill($request->only([
            'name',
            'video_id',
        ]));
//        $item->teacher_id = auth()->user()->id;
        $lesson->save();

        return redirect()->route('lessons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lesson $lesson
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index');
    }
}
