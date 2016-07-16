<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// 使用call方法执行额外的填充类
        $this->call(UserTableSeeder::class);
    }
}
