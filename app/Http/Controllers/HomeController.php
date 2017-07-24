<?php

namespace App\Http\Controllers;

use App\Facades\Search;
use App\Models\Course;
use App\Models\Setting;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
//        Auth::loginUsingId(1, true);
        if ($request->route()->hasParameter('category')) {
            $categoryId = $request->route('category');
            $orderBy = $request->get('sort', 'time');
            switch ($orderBy) {
                case 'time':
                    $items = $this->coursesOrderByCreationTime($request, $categoryId);
                    break;
                case 'hot':
                    $items = $this->coursesOrderByUserCount($request, $categoryId);
                    break;
                case 'rate':
                    $items = $this->coursesOrderByCommentRating($request, $categoryId);
                    break;
            }
            return $items;
        }

        $pageSize = 10;
        $index = new Term();
        $index->id = '0';
        $index->name = '新课速递';
        $categories = [$index];
        $categoriesFromDB = Term::where('type', 'category')
            ->select('id', 'name')
            ->get();
        $categories = array_merge($categories, $categoriesFromDB->all());

        $data = [];
//        ////
        foreach ($categories as $category) {
            $recommendedCourse = $this->recommendedCourses($category->id);
            list($items, $recommendedCourse) = $this->coursesOrderByCreationTime($request, $category->id, 10, $recommendedCourse);
            list($itemsOrderByUserCount, $recommendedCourse) = $this->coursesOrderByUserCount($request, $category->id, 10, $recommendedCourse);
            list($itemsOrderByCommentRating, $recommendedCourse) = $this->coursesOrderByCommentRating($request, $category->id, 10, $recommendedCourse);
            $hasRecommendedCourse = (bool)count($recommendedCourse);
            $data[] = compact(
                'category',
                'items',
                'itemsOrderByUserCount',
                'itemsOrderByCommentRating',
                'hasRecommendedCourse',
                'recommendedCourse'
            );
        }
//        ////
        ///
//        $page = $request->get('page', 1);
//        foreach ($categories as $category) {
//            if ($category->id == 0) {
//                $recommendedCourseSetting = Setting::where('key', 'recommendedCourse')->first();//dd($recommendedCourse);
//                $recommendedCourse = $recommendedCourseSetting
//                    ? Course::where('id', ($recommendedCourseSetting->value))->get()
//                    : null;
//            } else {
//                $recommendedCourse = Course::where('hot', true)
//                    ->where('category_id', $category->id)
//                    ->get();
//            }
//
//            $items = Search::basicStat()
//                ->orderBy('id', 'desc');
////            dd($items->toSql());
//            $itemsOrderByUserCount = Search::basicStat()
//                ->orderBy('users_count', 'desc');
//            $itemsOrderByCommentRating = Course::select(DB::raw('courses.*'))
//                ->addSelect(DB::raw('(select count(*) from `users` inner join `course_user` on `users`.`id` = `course_user`.`user_id` where `courses`.`id` = `course_user`.`course_id` and `type` = ' . '\'student\'' . ') as `users_count`'))
//                ->addSelect(DB::raw('(select count(*) from `comments` where `comments`.`course_id` = `courses`.`id`) as `comments_count`'))
//                ->addSelect(DB::raw('(select sum(comments.star) from `comments` where `comments`.`course_id` = `courses`.`id`) as `star`'))
//                ->orderBy('star', 'desc');
////            dd($itemsOrderByCommentRating->toSql());
//            //Dev
//            foreach ([$items, $itemsOrderByUserCount, $itemsOrderByCommentRating] as $builder) {
//                if ($category->id > 0) {
//                    $builder->where('category_id', $category->id);
//                }
//                if (count($recommendedCourse)) {
//                    $builder->where('courses.id', '<>', $recommendedCourse->first()->id);
//                }
//            }
//
//            $items = $this->processPage($page, $items, $pageSize, $recommendedCourse);
//            $itemsOrderByUserCount = $this->processPage($page, $itemsOrderByUserCount, $pageSize, $recommendedCourse);
//            $itemsOrderByCommentRating = $this->processPage($page, $itemsOrderByCommentRating, $pageSize, $recommendedCourse);
////            dd($items);
//            $hasRecommendedCourse = (bool)count($recommendedCourse);
//            $data[] = compact('items',
//                'itemsOrderByUserCount',
//                'itemsOrderByCommentRating',
//                'hasRecommendedCourse',
//                'recommendedCourse'
//            );
//        }

//        dd($data[0]);
//        dd($data);
//        $jsSdk = new JSSDK(config('wechat.mp.app_id'), config('wechat.mp.app_secret'));
//        $signPackage = $jsSdk->getSignPackage();
//        return view('video.display',
//            compact('categories', 'data')
//        );
        return view('course.index',
            compact('categories', 'data')
        );
    }

    //某分类下的置顶推荐课程
    private function recommendedCourses($categoryId)
    {

        if ($categoryId == 0) {
            $recommendedCourseSetting = Setting::where('key', 'recommendedCourse')->first();//dd($recommendedCourse);
            $recommendedCourse = $recommendedCourseSetting
                ? Course::where('id', ($recommendedCourseSetting->value))->get()
                : null;
        } else {
            $recommendedCourse = Course::where('hot', true)
                ->where('category_id', $categoryId)
                ->get();
        }
        return $recommendedCourse;
    }

    //按创建时间排序的课程
    public function coursesOrderByCreationTime(Request $request, $categoryId = 0, $pageSize = 10, $recommendedCourse = null)
    {
        $page = $request->get('page', 1);
        $recommendedCourse = $recommendedCourse ?: $this->recommendedCourses($categoryId);
        $items = Search::basicStat()
            ->orderBy('id', 'desc');
        if ($categoryId > 0) {
            $items->where('category_id', $categoryId);
        }
        if (count($recommendedCourse)) {
            $items->where('courses.id', '<>', $recommendedCourse->first()->id);
        }
        $items = $this->processPage($page, $items, $pageSize, $recommendedCourse);
        return [$items, $recommendedCourse];
    }

    //按学员数排序的课程
    public function coursesOrderByUserCount(Request $request, $categoryId, $pageSize = 10, $recommendedCourse = null)
    {
        $page = $request->get('page', 1);
        $recommendedCourse = $recommendedCourse ?: $this->recommendedCourses($categoryId);
        $itemsOrderByUserCount = Search::basicStat()
            ->orderBy('users_count', 'desc');
        if ($categoryId > 0) {
            $itemsOrderByUserCount->where('category_id', $categoryId);
        }
        if (count($recommendedCourse)) {
            $itemsOrderByUserCount->where('courses.id', '<>', $recommendedCourse->first()->id);
        }
        $itemsOrderByUserCount = $this->processPage($page, $itemsOrderByUserCount, $pageSize, $recommendedCourse);
        return [$itemsOrderByUserCount, $recommendedCourse];
    }

    //按评价排序的课程
    public function coursesOrderByCommentRating(Request $request, $categoryId, $pageSize = 10, $recommendedCourse = null)
    {
        $page = $request->get('page', 1);
        $recommendedCourse = $recommendedCourse ?: $this->recommendedCourses($categoryId);
        $itemsOrderByCommentRating = Course::select(DB::raw('courses.*'))
            ->addSelect(DB::raw('(select count(*) from `users` inner join `course_user` on `users`.`id` = `course_user`.`user_id` where `courses`.`id` = `course_user`.`course_id` and `type` = ' . '\'student\'' . ') as `users_count`'))
            ->addSelect(DB::raw('(select count(*) from `comments` where `comments`.`course_id` = `courses`.`id`) as `comments_count`'))
            ->addSelect(DB::raw('(select sum(comments.star) from `comments` where `comments`.`course_id` = `courses`.`id`) as `star`'))
            ->orderBy('star', 'desc');
        if ($categoryId > 0) {
            $itemsOrderByCommentRating->where('category_id', $categoryId);
        }
        if (count($recommendedCourse)) {
            $itemsOrderByCommentRating->where('courses.id', '<>', $recommendedCourse->first()->id);
        }
        $itemsOrderByCommentRating = $this->processPage($page, $itemsOrderByCommentRating, $pageSize, $recommendedCourse);
        return [$itemsOrderByCommentRating, $recommendedCourse];
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

    /**
     * @param $page
     * @param $items
     * @param $pageSize
     * @param $recommendedCourse
     * @return LengthAwarePaginator
     */
    public function processPage($page, $items, $pageSize, $recommendedCourse)
    {
        if ($page > 1) {
            $count = $items->count();
            $prevPageItems = $items
                ->offset(($page - 2) * $pageSize)->limit($pageSize)
                ->get()->slice($pageSize - count($recommendedCourse));
            $currPageItems = $items->paginate($pageSize);//->forPage(1, $pageSize - count($recommendedCourse));
//                dd($currPageItems);
            $items = $prevPageItems->merge($currPageItems)->splice(0, $pageSize);
            $items = new LengthAwarePaginator($items, $count + count($recommendedCourse), $pageSize, $page);
        } else {
            $items = $items->paginate($pageSize)->splice(0, $pageSize - 1);
            $items = $recommendedCourse->merge($items);
//                dd($recommendedCourse);
        }
        return $items;
    }

}
