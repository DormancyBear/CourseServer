<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('courseid')->unique(); // 将课程编号设为索引
            $table->string('name'); // 课程名称
            $table->string('teacher');  // 授课老师姓名
            $table->integer('week');    // 上课日期
            $table->integer('start');   // 上课时间
            $table->integer('end'); //下课时间
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('courses');
    }
}
