<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Tools\Category;
use App\Permission;

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
        $permissions = Permission::all()->toArray();
        $permissions = Category::proMenu($permissions);
        return view('admin.home.home', compact('permissions'));
    }

    public function __construct()
    {
        $this->middleware('admin_auth');
    }

}
