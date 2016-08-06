<?php

/**
* 测试用例 => phpunit.xml 为整个测试环境的配置文件
* testsuites 中定义了测试文件的存放路径
* filter 中定义了需要进行单元测试的PHP文件存放位置
* php 中配置了测试环境的环境变量
*/

/**
* 在 CMD 下执行 $vendor\bin\phpunit 开始测试
* CMD 将输出一个字符来表明测试结果
* E -> Printed when an error occurs while running the test method
* F -> Printed when an assertion fails while running the test method
*/

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

// 测试 JSON API 及其响应
class ApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
    	// seeJson 方法将给定数组转化为 JSON，然后验证应用返回的整个 JSON 响应中的 JSON 片段
        // click($param) 方法的参数 $param 支持显示的字符串、name属性、id属性
        $this->get('stuid/123/password/456')
        	->seeJson([
        		'code' => 200,
        	]);
    }
}
