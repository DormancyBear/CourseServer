<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * 在构建 Json API 时，可以通过 toJson 方法将查询到的数据库结果集合直接转化为 Json 数据格式，方便了我们很多
     * 但有些字段，我们并不想要它们也转化为 Json 数据并发送给客户端，
     * 这时，将这些想要隐藏掉的字段都赋给 $hidden，
     * 当用 toJson 方法转化集合的时候，这些字段会被忽略掉。
     * @var array
     */
    protected $hidden = ['id', 'created_at', 'updated_at'];
}
