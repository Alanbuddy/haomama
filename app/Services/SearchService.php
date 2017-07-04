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

    //课程评论数和学员数和所属分类信息
    public function basicStat()
    {
        $items = Course::withCount('comments')
            ->withCount(['users' => function ($query) {
                $query->where('type', 'enroll');
            }])
            ->with('category');//预加载课程所属分类的信息
        return $items;
    }

    public function enrolledCourses($userId)
    {
        return $this->basicStat()
            ->join('course_user', 'course_user.course_id', 'courses.id')
            ->where('course_user.type', 'enroll')
            ->where('course_user.user_id', $userId);
    }

    public function favoritedCourses($userId)
    {
        return $this->basicStat()
            ->join('course_user', 'course_user.course_id', 'courses.id')
            ->where('course_user.type', 'favorite')
            ->where('course_user.user_id', $userId);
    }

    //在课程有效期内的线下课程
    public function onGoingCourses($userId)
    {
        return $this->enrolledCourses($userId)
            ->where('courses.type', 'offline')
//            ->with('lessons')
            ->with('onGoingLessons')
            ->where('begin', '<', date('Y-m-d H:i:s', time()))
            ->where('end', '>', date('Y-m-d H:i:s', time()));
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
        $items = $tag->coursesByTag();
        return $items;
    }

    /**
     * 根据分类名搜索课程
     * @param Request $request
     * @param Term $category
     */
    public function coursesByCategory(Term $category)
    {
        $items = $category->coursesByCategory();
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

    //根据标签相似程度推荐课程,返回包含其他课程ID的数组
    public function popularTags()
    {
        $tags = DB::table('term_object')
            ->join('terms', 'term_object.term_id', '=', 'terms.id')
            ->select(DB::raw('terms.*'))
            ->addSelect(DB::raw('count(*) as count'))
            ->groupBy('term_id')
            ->where('term_object.type', 'tag')
            ->paginate(6);
        return $tags;
    }

    public function search($key)
    {
        $items = $this->basicStat()
            ->leftJoin('users','users.id','courses.teacher_id')
            ->where('courses.name','like','%'.$key.'%')
            ->orWhere('courses.name','like','%'.$key.'%')
            ->orderBy('courses.id','desc');
        return $items;
    }
}