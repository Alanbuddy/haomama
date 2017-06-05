<?php
/**
 * Created by PhpStorm.
 * User: gao
 * Date: 17-5-15
 * Time: 上午9:34
 */

namespace App\Services;


use App\Models\Course;
use App\Models\Term;
use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SearchService
{
    public function courses(Request $request)
    {
        $items = Course::where('id', '>', 0);
        foreach ($request->except('page') as $k => $v) {
            $items = $items->where($k, $v);
        }
        return $items;
    }

    //统计课程评论数和学员数
    public function latestCourse()
    {
        $items = Course::withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->with('category');//预加载课程所属分类的信息
        return $items;
    }

    //统计课程
    public function coursesStatistics()
    {
        $items = Course::withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->withCount(['users as favorite' => function ($query) {
                $query->where('type', 'favorite');
            }])
//            ->join('orders','orders.product_id','courses.id')
            ->with('category');//预加载课程所属分类的信息
        return $items;
    }

    public function coursesByTag($tag)
    {
        $tag = Term::findOrFail($tag);
        $items = $tag->coursesByTag()
            ->paginate(10);
        return $items;
    }

    /**
     * 根据分类名搜索课程
     * @param Request $request
     * @param Term $category
     */
    public function coursesByCategory($category)
    {
        $category = Term::findOrFail($category);
        $items = $category->coursesByCategory()
            ->paginate(10);
        return $items;
    }

    //根据标签相似程度推荐课程,返回包含其他课程ID的数组
    public function recommend(Course $course)
    {
        $tags = $course->tags;
        $collection = collect([]);
        foreach ($tags as $tag) {
            $courses = $tag->coursesByTag;
            foreach ($courses as $item) {
                $collection->put($item->id,
                    $collection->get($item->id, 0) + 1);
            }
        }
        $sorted = $collection->sort()->reverse();
        $sorted->pull($course->id);
        return $sorted;
    }
}