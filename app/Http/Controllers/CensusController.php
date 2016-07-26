<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Student;
use App\Course;

use Illuminate\Database\QueryException;

class CensusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function studentInfo(Request $request)
    {
        // 使用 hasFile 方法判断文件在请求中是否存在
        if (!$request->hasFile('studentFile')) {
            return redirect()->route('home');
        }
        // file 方法访问上传文件，返回 Symfony\Component\HttpFoundation\File\UploadedFile 类的一个实例
        $studentFile = $request->file('studentFile');
        // dd($studentFile->getPathname());
        // 使用 isValid 方法判断文件在上传过程中是否出错
        if (!$studentFile->isValid()) {
            return redirect()->route('home');
        }
        // SplFileInfo::getPathname — php 自带函数, Gets the path to the file
        $studentContent = fopen($studentFile->getPathname(), "r");
        while(!feof($studentContent)) {
            $str = fgets($studentContent);
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
        fclose($studentContent);
        return redirect()->route('home');
    }

    public function courseInfo(Request $request)
    {
        if (!$request->hasFile('courseFile')) {
            return redirect()->route('home');
        }
        $courseFile = $request->file('courseFile');
        if (!$courseFile->isValid()) {
            return redirect()->route('home');
        }

        $courseContent = fopen($courseFile->getPathname(), "r");
        while(!feof($courseContent)) {
            $str = fgets($courseContent);
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
        fclose($courseContent);
        return redirect()->route('home');
    }
}
