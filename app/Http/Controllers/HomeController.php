<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Http\Wechat\JSSDK;
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
            $orderBy=$request->get('sort','created_at');
            $limit=['users_count','comment_rate'];
            $items = Search::latestCourse()
                ->orderBy($orderBy,'desc')
                ->paginate();
        }
        dd($items->all());

        //retrieve data needed by index page
        foreach ($items as $i) {
            echo($i->id);
            echo($i->category->name);
        }
        $categories = Term::where('type', 'category')
            ->select('id', 'name')
            ->get();

        $jsSdk = new JSSDK(config('wechat.mp.app_id'), config('wechat.mp.app_secret'));
        $signPackage = $jsSdk->getSignPackage();

        $data = compact('categories', 'items', 'signPackage');
//        dd($categories);

        return view('course.index', $data);
//        return view('video.display', $data);
    }

}
