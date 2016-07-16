<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Student; // 导入 Student 模型
use App\Timetable;
use App\Course;

use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiController extends Controller
{
    /**
    * Json 数据结构
    * $code => 状态码
    * $count => 此学生拥有的课程数量
    * $data => 具体课程信息
    */

    // 访问路由参数 stuid 和 password
    public function showJson($stuid, $password)
    {
        // firstOrFail方法返回匹配查询条件的第一个模型实例
        // 如果没有任何查询结果，就会抛出 Illuminate\Database\Eloquent\ModelNotFoundException 异常
        try {
            $student = Student::where('stuid', '=', $stuid)->firstOrFail();
            if ($password != $student->password)
            {
                // Json 数据中状态码为 400 时表示密码错误
                // var_dump($student->password);
                $code = 400;
                $count = 0;
                $courses = collect(['code' => $code, 'count' => $count]);
                echo $courses->toJson();
            }
            else {
                // 状态码为 200 时表示登录成功
                $code = 200;
                // get 方法返回查询到的结果集合(Illuminate\Database\Eloquent\Collection的一个实例)，类似于一个数组
                $timetables = Timetable::where('stuid', '=', $stuid)->get();
                $count = $timetables->count();
                // 创建集合
                $courses = collect(['code' => $code, 'count' => $count]);
                $i = 0;
                foreach ($timetables as $timetable) {
                    $i++;
                    $course = Course::where('courseid', '=', $timetable->courseid)->first();
                    // put方法在集合中设置给定键和值，注意“值”可以再次嵌套一个集合
                    $courses->put($i, $course);
                }
                echo $courses->toJson();
            }
        } catch(ModelNotFoundException $e) {
            // 没有找到对应用户名就抛出异常
            // Json 数据中状态码为 401 时表示用户名错误
            $code = 401;
            $count = 0;
            $courses = collect(['code' => $code, 'count' => $count]);
            echo $courses->toJson();
        }
    }
}
