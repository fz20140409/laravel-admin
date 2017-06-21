<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

/**
 * 后台主页控制器
 * Class HomeController
 * @package App\Http\Controllers\Admin
 */
class HomeController extends BaseController
{
    //
    function home()
    {
        return view('admin.home.home');
    }

    public function __construct()
    {
        $this->middleware('admin_auth');
    }

}
