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

    public function latestCourse()
    {
        $items = Course::withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->with('category')//预加载课程所属分类的信息
            ->paginate();
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
}