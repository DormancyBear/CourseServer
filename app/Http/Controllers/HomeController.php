<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Timetable;
use App\Course;
use App\Student;

use Illuminate\Database\Eloquent\Collection;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $initialStudents = Student::all();
        $initialCourses = Course::all();

        return view('home', ['initialStudents' => $initialStudents, 'initialCourses' => $initialCourses]);
    }

    public function add(Request $request)
    {
        $timetable = new Timetable;
        $timetable->stuid = $request->stuid;
        $timetable->courseid = $request->courseid;
        $timetable->save();
        return view('home');
    }

    // 通过依赖注入获取当前 HTTP 请求实例
    // 在控制器方法的参数中对 Illuminate\Http\Request 类进行类型提示(Request $request)，当前请求实例会被服务容器自动注入
    public function queryStuid(Request $request)
    {
        $stuid = $request->input('stuid');
        // var_dump($stuid);
        $timetables = Timetable::where('stuid', '=', $stuid)->get();
        // var_dump($timetables);
        $courses = new Collection;
        foreach ($timetables as $timetable) {
            $course = Course::where('courseid', '=', $timetable->courseid)->first();
            // push方法附加数据项到集合结尾，这里是将多个一维集合拼接成了多维集合
            $courses->push($course);
        }
        // var_dump($courses);
        // 通过数组方式将数据传递到视图，在视图中可以使用相应的键来访问数据值
        return view('home', ['courses' => $courses, 'stuid' => $stuid]);
    }

    public function deleteCourse($stuid, $courseid)
    {
        Timetable::where('stuid', '=', $stuid)
            ->where('courseid', '=', $courseid)
            ->delete();
        return redirect('/home');
    }

    public function queryCourseid(Request $request)
    {
        $courseid = $request->input('courseid');
        $timetables = Timetable::where('courseid', '=', $courseid)->get();
        // var_dump($timetables);
        $students = new Collection;
        foreach ($timetables as $timetable) {
            $student = Student::where('stuid', '=', $timetable->stuid)->first();
            // push方法附加数据项到集合结尾，这里是将多个一维集合拼接成了多维集合
            $students->push($student);
        }
        // 通过数组方式将数据传递到视图，在视图中可以使用相应的键来访问数据值
        return view('home', ['students' => $students, 'courseid' => $courseid]);
    }

    public function queryStuidNumber(Request $request)
    {
        $stuid = $request->input('stuid');
        $coursesNum = Timetable::where('stuid', '=', $stuid)->count();
        
        return view('home', ['coursesNum' => $coursesNum]);
    }

    public function queryCourseidNumber(Request $request)
    {
        $courseid = $request->input('courseid');
        $studentsNum = Timetable::where('courseid', '=', $courseid)->count();
        
        return view('home', ['studentsNum' => $studentsNum]);
    }
}
