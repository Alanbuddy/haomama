<?php

namespace App\Http\Controllers;

use App\Models\Behavior;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BehaviorController extends Controller
{
    function __construct()
    {
        $this->middleware('role:admin')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Behavior::where('id', '>', '0')
            ->select('id', 'user_id', 'type')
            ->addSelect(DB::raw('data->"$.time" as time'))
            ->paginate(10);
//        dd($items);
        return view('admin.user_behavior.index', [
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
        return view('admin.user_behavior.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Behavior();
        $item->fill($request->only([
            'type',
            'data',
        ]));
        auth()->user()->behaviors()->save($item);

        return redirect()->route('behaviors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function show(Behavior $behavior)
    {
        return view('admin.user_behavior.show', [
            'item' => $behavior,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function edit(Behavior $userBehavior)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Behavior $userBehavior)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Behavior $userBehavior
     * @return \Illuminate\Http\Response
     */
    public function destroy(Behavior $userBehavior)
    {
        //
    }

    public function latest(Request $request)
    {
        $items = Behavior::where('id', '>', '0')
            ->select('id', 'user_id', 'type')
            ->addSelect(DB::raw('data->"$.time" as time'))
//            ->where(DB::raw('json_search(data,"one","%2%")'),'like', '%2%')
            ->paginate(10);
        dd($items);
    }
}
