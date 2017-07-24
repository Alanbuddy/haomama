<?php

namespace App\Http\Controllers;

use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
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
    public function index(Request $request)
    {
        $items = Term::where('type', $request->get('type', 'tag'))
            ->paginate(10);
        return view('admin.term.index', [
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
        return view('admin.term.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'type' => 'required']);
        $existing=Term::where('type','tag')
            ->where('name',$request->name)
            ->where('type',$request->type)->first();
        if($existing)
            return ['success' => true, 'data' => $existing];
        $item = new Term();
        $item->fill($request->only([
            'name',
            'type',
        ]));
        $item->save();
        if ($request->ajax()) {
            return ['success' => true, 'data' => $item];
        }
        return redirect()->route('terms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Term $term
     * @return \Illuminate\Http\Response
     */
    public function show(Term $term)
    {
//        if ($term->type == 'tag')
//            dd(Search::coursesByTag($term));
//        if ($term->type == 'category')
//            dd(Search::coursesByCategory($term));
        return view('admin.term.show', [
            'item' => $term,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Term $term
     * @return \Illuminate\Http\Response
     */
    public function edit(Term $term)
    {
        return view('admin.term.edit', [
            'item' => $term,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Term $term
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Term $term)
    {
        $term->name = $request->name;
        $term->save();
        return view('admin.term.edit', [
            'item' => $term,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Term $term
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Term $term)
    {
        $term->delete();
        if ($request->ajax()) {
            return ['success' => true];
        }
        return redirect()->route('terms.index');
    }
}
