<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Student;
use App\Course;

use Illuminate\Database\QueryException;

class CensusController extends Controller
{
    public function studentInfo()
    {
        // public_path 函数返回 public 目录的绝对路径
        $student_dir = public_path() . "\data\studentInfo.txt";
        // var_dump() 打印变量的相关信息
        //var_dump($student_dir);
        $studentFile = fopen($student_dir, "r");
        while(!feof($studentFile)) {
            $str = fgets($studentFile);
            if (!empty($str)) {
                $arr = explode(" ", $str);

                //将此行记录插入数据库
                $student = new Student;
                // trim() 函数移除字符串两侧的空白字符
                $student->stuid = trim($arr[0]);
                $student->name = trim($arr[1]);
                $student->password = trim($arr[2]);
                try {
                    $student->save();
                } catch(QueryException $e) {
                } 
            }
        }
        fclose($studentFile);
        return redirect()->route('home');
    }

    public function courseInfo()
    {
        $course_dir = public_path() . "\data\courseInfo.txt";
        $courseFile = fopen($course_dir, "r");
        while(!feof($courseFile)) {
            $str = fgets($courseFile);
            if (!empty($str)) {
                $arr = explode(" ", $str);

                //将此行记录插入数据库
                $course = new Course;
                $course->courseid = trim($arr[0]);
                $course->name = trim($arr[1]);
                $course->teacher = trim($arr[2]);
                $course->week = trim($arr[3]);
                $course->start = trim($arr[4]);
                $course->end = trim($arr[5]);
                try {
                    $course->save();
                } catch(QueryException $e) {
                }
            }
        }
        fclose($courseFile);
        return redirect()->route('home');
    }
}
