<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Timetable;
use App\Course;
use App\Student;

use Illuminate\Database\Eloquent\Collection;
use Session;    // 导入 Session facade

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 在控制器的构造函数中使用 middleware 方法分配中间件给该控制器
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
        // validate方法验证失败=>重定向至用户上一个页面，错误信息一次性暂存到 session 中(每次请求的所有视图中总是存在一个$errors变量)
        $this->validate($request, [
            // 用户输入的 stuid 值需存在于 students 这个数据表的 stuid 字段中，即：已存在该学生才能给该学生分配课表
            'stuid'    => 'exists:students,stuid',
            'courseid' => 'exists:courses,courseid',
        ]);
        // dd('执行到了这里...');

        $timetable = new Timetable;
        $timetable->stuid = $request->stuid;
        $timetable->courseid = $request->courseid;
        $timetable->save();
        
        return redirect()->route('home');
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

        // 将需要的数据保存到 session 中
        Session::put('stuid', $stuid);
        Session::put('courses', $courses);

        // var_dump($courses);
        // 重定向到命名路由 home
        return redirect()->route('home');
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

        Session::put('courseid', $courseid);
        Session::put('students', $students);
        return redirect()->route('home');
    }

    public function queryStuidNumber(Request $request)
    {
        $stuid = $request->input('stuid');
        $coursesNum = Timetable::where('stuid', '=', $stuid)->count();

        Session::put('coursesNum', $coursesNum);
        return redirect()->route('home');
    }

    public function queryCourseidNumber(Request $request)
    {
        $courseid = $request->input('courseid');
        $studentsNum = Timetable::where('courseid', '=', $courseid)->count();

        Session::put('studentsNum', $studentsNum);
        return redirect()->route('home');
    }
}
