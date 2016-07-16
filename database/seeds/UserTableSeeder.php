<?php

use Illuminate\Database\Seeder;

use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// firstOrCreate方法先尝试通过给定列/值对在数据库中查找记录，如果没有找到的话则通过给定属性创建一个新的记录
        User::firstOrCreate([
        	'name' => 'root',
        	'email' => '123@456.com',
        	// 调用 Hash 门面上的 make 方法散列存储密码
        	'password' => Hash::make('root'),
        ]);
    }
}
