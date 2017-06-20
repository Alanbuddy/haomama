<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Vote;
use Illuminate\Http\Request;

class CommentController extends Controller
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
        $items = Comment::paginate(10);
        return view('admin.comment.index', [
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
        return view('admin.comment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Comment();
        $item->fill($request->only([
            'content',
            'star',
            'course_id'
        ]));
//        $item->course_id = 2;
//        $item->teacher_id = auth()->user()->id;
        auth()->user()->comments()->save($item);
        return redirect()->route('comments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Comment $comment)
    {
        return view('admin.comment.show', [
            'item' => $comment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('admin.comment.edit', [
            'item' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->fill($request->only([
            'content',
            'star',
        ]));
        $comment->update();
        return redirect()->route('comments.edit', $comment->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index');
    }

    public function vote(Request $request, Comment $comment)
    {
        $vote = Vote::where('comment_id', $comment->id)
            ->where('user_id', auth()->user()->id)
            ->first();
        $hasVoted = (bool)$vote;
        if ($vote) {
            $vote->delete();
        } else {
            $vote = new Vote();
            $vote->fill([
                'comment_id' => $comment->id,
                'user_id' => auth()->user()->id
            ]);
            $vote->save();
        }
        return ['success' => true, 'message' => '' . !$hasVoted];
    }
}
