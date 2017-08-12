<?php

namespace App\Http\Controllers;

use App\Http\Util\ChunkedUpload;
use App\Http\Util\IO;
use App\Models\Course;
use App\Models\File;
use App\Models\Lession;
use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LessonController extends Controller
{
    use SignInTrait, CommentTrait, IO, CourseTitleTrait;

    function __construct()
    {
        $this->middleware('role:admin|operator')->except('show', 'detail');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->get('type');
        $items = Lesson::orderBy('id', 'desc');
        if ($type) {
            $items->where('type', $type);
        }
        $items = $items->paginate(10);
        $items->withPath(route('lessons.index')); //$items->withPath(($request->getClientIp() == '127.0.0.1' ? '' : '/haomama') . '/lessons');
        if ($request->ajax()) {
            return $items;
        }
        return view($type == 'video'
            ? 'admin.lesson.index'
            : 'admin.lesson.audio_index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'video');
        $item = null;
        if ('audio' == $type) {
            $item = new Video();
            $item->video_type = "compound";
            $item->mime = "video/";
            auth()->user()->videos()->save($item);
        }
        return view($type == 'video'
            ? 'admin.lesson.new'
            : 'admin.lesson.audio',
            [
                'item' => $item,
            ]
        );
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'video_id' => 'required',
            'name' => 'unique:lessons'
        ]);
        $item = new Lesson();
        $item->fill($request->only(['name', 'type', 'video_id', 'begin', 'end', 'description',]));
        if ($request->file('cover')) {
            $folderPath = public_path('storage/lesson/' . $item->id);
            $cover = $this->moveAndStore($request, 'cover', $folderPath);
            $item->cover = $cover->path;
        }
        $type = $request->get('type', 'video');
        if ('audio' == $type) {
            $this->storeAttachments($request, $item);
        }
        $item->save();
        if ($request->json()) {
            return ['success' => true, 'data' => $item->id];
        }
        return redirect()->route('lessons.index');
    }

    public function storeAttachments(Request $request, Lesson $lesson)
    {
        $video = Video::find($request->video_id);
        if ($request->has('pictures')) {
            $arr = $video->attachments()
                ->where('mime', 'like', 'image%')
                ->select('id')->get()->all();
            $video->attachments()->detach(array_map(function ($v) {
                return $v->id;
            }, $arr));

            $tmp = [];
            $arr = $request->pictures;
            foreach ($arr as $p) {
                $tmp[$p['file']] = ['no' => $p['time']];
            }
            $video->attachments()->attach($tmp);
        }
        if ($request->has('audio')) {
            $arr = $video->attachments()
                ->where('mime', 'like', 'audio%')
                ->select('id')->get()->all();
            $video->attachments()->detach(array_map(function ($v) {
                return $v->id;
            }, $arr));
            $audio = File::find($request->audio);
            $video->attachments()->attach($audio->id);
        }
        if ($request->file('timeline')) {
            $file = $request->file('timeline');
            $ret = $this->parseTimeline(file_get_contents($file));
            $video->caption = json_encode($ret);
            $video->save();
        }
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

        $video = $lesson->video;
        $data = compact('video', 'lesson', 'comments');
        if ($lesson->type == 'audio') {
            $pictures = $video->pictures()
                ->orderBy('no')
                ->get();
            $audio = $video->attachments()
                ->where('mime', 'like', 'audio%')
                ->first();
            $data = array_merge($data, compact('pictures', 'audio'));
        }
        return view('setting.lesson', $data);
    }

    //后台课时详情管理页
    public function adminShow(Request $request, Lesson $lesson)
    {
        $type = $request->get('type', 'video');
        $video = $lesson->video;
        $coursesCount = $lesson->course()->count();
        $canDelete = $coursesCount == 0;//如果有课程中引用到这个lesson，就不允许删除当前lesson
        $data = compact('video', 'lesson', 'coursesCount', 'canDelete');
        if ($lesson->type == 'audio') {
            $pictures = $video->pictures()
                ->orderBy('no')
                ->get();
            $audio = $video->attachments()
                ->where('mime', 'like', 'audio%')
                ->first();
            $data = array_merge($data, compact('pictures', 'audio'));
        }
        return view('video' == $type
            ? 'admin.lesson.show'
            : 'admin.lesson.audio_show', $data);
    }

    //课程下的某一个课时详情
    public function detail(Course $course, Lesson $lesson)
    {
        $comments = $this->hottestComments($course, $lesson, 3);
        $latestComments = $this->latestComments($course, $lesson);

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
        $titles = json_decode($course->titles);
        $lessons = $this->processTitles($titles, $lessons);
        $index = 0;//表示第几节课时
        $i = 0;
        foreach ($lessons as $item) {
            if ($item->id == $lesson->id) {
                $index = $i;
            }
            $i++;
        }
        if (!$hasEnrolled && $index > 0) {
            return back()->with('message', '请加入课程后观看');
        } else {
            $this->recordAttendance($course, $lesson);
        }

        $video = $lesson->video;
        if (!empty($video) && $video->video_type == 'compound') {
            $pictures = $video->pictures()->orderBy('no')->get();
            $audio = $video->audio()->first();
            $audio=$audio?:new File();
        }
        // dd($pictures);
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
            'video',
            'pictures',
            'audio'
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
        $video = $lesson->video();
        return view('admin.lesson.edit', compact('video', 'lesson'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        $lesson->fill($request->only([
            'name',
            'video_id',
            'description',
        ]));
        if ('audio' == $lesson->type) {
            $this->storeAttachments($request, $lesson);
        }
        $lesson->save();
        if ($request->ajax()) {
            return ['success' => true];
        }
        return redirect()->route('lessons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lesson $lesson
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request, Lesson $lesson)
    {
        $canDelete = $lesson->course()->count() == 0;
        if ($canDelete)
            $lesson->delete();
        if ($request->ajax()) {
            return ['success' => $canDelete];
        }
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

    public function adminSearch(Request $request)
    {
        if ($request->has('key')) {
            $items = Lesson::where('name', 'like', '%' . $request->key . '')
                ->orderBy('id', 'desc')
                ->paginate(10);
//            dd($items);
            return view('admin.lesson.lesson_search', [
                'items' => $items,
            ]);
        }
        return redirect()->route('lessons.index');
    }

    public function comments(Course $course, Lesson $lesson)
    {
        $comments = $this->latestComments($course, $lesson);
        return $comments;
    }
}
