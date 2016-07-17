<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
	// 此处 Controller 基类使用了一个 ValidatesRequests 的 trait
	// 此 trait 提供了一个 validate 方法来专门验证 HTTP 请求
	// public function store(Request $request)
	// {
	//     $this->validate($request, [
	//         'title' => 'required|unique|max:255',
	//         'body' => 'required',
	//     ]);
	// }
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
}
