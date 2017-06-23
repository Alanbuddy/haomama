<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //set all messages status to has been read
        auth()->user()->messages()
            ->where('has_read', false)
            ->update(['has_read' => true]);

        $messages = auth()->user()
            ->comments()
            ->with(['votes' => function ($query) {
                $query->orderBy('id', 'desc')->paginate(1);
            }])
            ->join('messages', 'messages.object_id', '=', 'comments.id')
            ->select(DB::raw('comments.*'))//->where('messages.has_read',false)
            ->addSelect(DB::raw('sum(messages.id) as messageCount'))
            ->groupBy('comments.id')
            ->get();
//            ->messages()
//            ->leftJoin('comments', 'comments.id', '=', 'messages.object_id')
//            ->orderBy('id','desc')
//            ->with('comment.user')
//            ->select('from')
//            ->addSelect(DB::raw('sum(object_id) as voteCount'))
//            ->groupBy('comments.id')
//            ->get();
        dd($messages);
//        dd($messages, $messages[3]);
//        dd($messages[3]->comment,$messages[3]->comment->user);
        return view('setting.message', compact('messages'));
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
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
