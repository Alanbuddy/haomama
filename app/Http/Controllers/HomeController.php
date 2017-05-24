<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        //Dev
        Auth::loginUsingId(1);
        //

        $items = [];
        $hasFilter = false;
        $route = $request->route();
        if ($route->hasParameter('tag')) {
            $items = Search::coursesByTag($request->route('tag'));
            $hasFilter = true;
        }
        if ($route->hasParameter('category')) {
            $items = Search::coursesByCategory($request->route('category'));
            $hasFilter = true;
        }

        if (!$hasFilter) {
            $items = Search::latestCourse(); //dd(auth()->user()->courses);
        }

        //retrieve data needed by index page

        foreach ($items as $i) {
            echo($i->id);
            echo($i->category->name);
        }
        $categories = Term::where('type', 'category')
            ->select('id', 'name')
            ->get();
        $data = compact('categories', 'items');
//        dd($data);

        return view('video.display', $data);
    }

}
