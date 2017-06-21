<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Http\Wechat\JSSDK;
use App\Models\Course;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        Auth::loginUsingId(1);
        //
//        $items = Course::where('id', '>', 0);
//        $hasFilter = false;
//        if ($route->hasParameter('tag')) {
//            $items = Search::coursesByTag($request->route('tag'));
//            $hasFilter = true;
//        }

//        if ($route->hasParameter('category')) {
//            $items = Search::coursesByCategory($request->route('category'));
//            $hasFilter = true;
//        }

//        if (!$hasFilter) {
//            $items = Search::basicStat();
//        }
//        Log::info('------');


        //retrieve data needed by index page
//        foreach ($items as $i) {
//            echo($i->id);
//            echo($i->category->name);
//        }
        $index = new Term();
        $index->id = '0';
        $index->name = 'index';
        $categories = [$index];
        $categoriesFromDB = Term::where('type', 'category')
            ->select('id', 'name')
            ->get();
        $categories = array_merge($categories, $categoriesFromDB->all());

        $data = [];
        foreach ($categories as $category) {
            $items = Search::basicStat();
//            dd($items->toSql());

            $itemsOrderByUserCount = Search::basicStat()->orderBy('users_count', 'desc');

            $itemsOrderByCommentRating = Course:: leftJoin('comments', 'comments.course_id', 'courses.id')
                ->leftJoin('course_user','course_user.course_id','courses.id')
                ->select(DB::raw('courses.*'))
                ->addSelect(DB::raw('count(comments.id) as comments_count'))
                ->addSelect(DB::raw('count(course_user.user_id) as users_count'))
                ->addSelect(DB::raw('sum(comments.star) as star'))
                ->groupBy('courses.id')
                ->orderBy('star', 'desc');
            //Dev
//            dd(->toSql());
            foreach ([$items, $itemsOrderByUserCount, $itemsOrderByCommentRating] as $builder) {
                if ($category->id > 0) {
                    $builder->where('category_id', $category->id);
                }
            }
            $items = $items->paginate(10);
            $itemsOrderByUserCount = $itemsOrderByUserCount->paginate(10);
            $itemsOrderByCommentRating = $itemsOrderByCommentRating->paginate(10);
            $data[] = compact('items', 'itemsOrderByUserCount', 'itemsOrderByCommentRating');
        }
//        dd($data);

        $jsSdk = new JSSDK(config('wechat.mp.app_id'), config('wechat.mp.app_secret'));
        $signPackage = $jsSdk->getSignPackage();
        return view('video.display',//'course.index',
            compact('categories', 'data', 'signPackage')
        );
    }

}
