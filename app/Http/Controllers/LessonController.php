<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lession;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    use SignInTrait, CommentTrait;

    function __construct()
    {
        $this->middleware('role:admin')->except('index', 'show', 'detail');
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
        $comments = $lesson->comments()
            ->with('user')
            ->with('votes')
            ->orderBy('vote', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10);
        $this->addVoteStatisticsOfComment($comments);
//        $item->video->id
//        $item->video->file_name
//        $item->video->video_type
//        dd($comments);

        return view('setting.lesson', compact(
            'lesson',
            'comments'
        ));
    }

    //课程下的某一个课时详情
    public function detail(Course $course, Lesson $lesson)
    {
        $this->recordAttendance($course, $lesson);

        $comments = $this->hottestComments($course,$lesson, 3);
        $latestComments = $this->latestComments($course,$lesson);

        $count = auth()->user()->enrolledCourses()
            ->where('id', $course->id)
            ->count();
        $hasEnrolled = $count == 1 ? true : false;
        $this->addVoteStatisticsOfComment($comments);
        $this->addVoteStatisticsOfComment($latestComments);
//        dd($comments);

        $avgRate = $course->comments()
            ->whereNull('lesson_id')
            ->select(DB::raw('avg(star) as avg'))
            ->first()
            ->avg;
        $avgRate = round($avgRate, 1);

        $learnedCount = $lesson->attendances($course->id)->count();

        $lessons = $course->lessons()->get();//TODO  orderBy no.
        $index = 0;
        $i = 0;
        foreach ($lessons as $item) {
            if ($item->id == $lesson->id) {
                $index = $i;
            }
            $i++;
        }

        $video = $lesson->video;

        return view('setting.lesson', compact(
            'lesson',
            'comments',
            'hasEnrolled',
            'avgRate',
            'course',
            'lessons',
            'index',
            'learnedCount',
            'latestComments',
            'video'
        ));
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

    public function addVoteStatisticsOfComment($comments)
    {
        foreach ($comments as $comment) {
            $comment->voteCount = count($comment->votes);
            $hasVoted = false;
            foreach ($comment->votes as $vote) {
                if ($vote->user_id == auth()->user()->id)
                    $hasVoted = true;
            }
            $comment->hasVoted = $hasVoted;
        }
    }
}
