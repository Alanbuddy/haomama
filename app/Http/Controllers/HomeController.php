<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Models\Course;
use App\Models\Setting;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = 10;
        $recommendedCourse = Setting::where('key', 'recommendedCourse')->get();//dd($recommendedCourse);
        if ($recommendedCourse) {
            $recommendedCourse = Course::find($recommendedCourse->first()->value);
        }
        Auth::loginUsingId(1, true);
        $index = new Term();
        $index->id = '0';
        $index->name = '新课速递';
        $categories = [$index];
        $categoriesFromDB = Term::where('type', 'category')
            ->select('id', 'name')
            ->get();
        $categories = array_merge($categories, $categoriesFromDB->all());

        $data = [];
        $page = $request->get('page', 1);
        foreach ($categories as $category) {
            $items = Search::basicStat()
                ->orderBy('id', 'desc');
//            dd($items->toSql());

            $itemsOrderByUserCount = Search::basicStat()
                ->orderBy('users_count', 'desc');

            $itemsOrderByCommentRating = Course:: leftJoin('comments', 'comments.course_id', 'courses.id')
                ->leftJoin('course_user', 'course_user.course_id', 'courses.id')
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
                if (count($recommendedCourse)) {
                    $builder->where('id', '<>', $recommendedCourse->first()->id);
                }
            }

            if ($page > 1) {
                $count = count($items->get());
                $prevPageItems = $items
                    ->offset(($page - 2) * $pageSize) ->limit($pageSize)
                    ->get()->slice($pageSize - count($recommendedCourse));
//                dd($prevPageItems);
                $currPageItems = $items->paginate($pageSize);//->forPage(1, $pageSize - count($recommendedCourse));
//                dd($currPageItems);
                $items = $prevPageItems->merge($currPageItems);
                $items = new LengthAwarePaginator($items, $count + count($recommendedCourse), $pageSize, $page);
            } else {
                $items = $items->paginate($pageSize)->slice(0, $pageSize - count($recommendedCourse));
                $items = $recommendedCourse->merge($items);
            }
            dd($items);

            $itemsOrderByUserCount = $itemsOrderByUserCount->paginate(10);
            $itemsOrderByCommentRating = $itemsOrderByCommentRating->paginate(10);
            $data[] = compact('items', 'itemsOrderByUserCount', 'itemsOrderByCommentRating');
        }
        dd($data[0]['items']);
        dd($data);
//        $jsSdk = new JSSDK(config('wechat.mp.app_id'), config('wechat.mp.app_secret'));
//        $signPackage = $jsSdk->getSignPackage();
//        return view('video.display',
//            compact('categories', 'data')
//        );
        return view('course.index',
            compact('categories', 'data')
        );
    }

    public function none()
    {
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
    }

}
