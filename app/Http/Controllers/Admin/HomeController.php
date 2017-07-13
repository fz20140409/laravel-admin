<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Tools\Category;

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
        if (!session('perms')) {
            $perms = array();
            $datas = Auth::user()->roles()->with(['perms' => function ($query) {
                $query->where('ishow', 1);
            }])->get()->toArray();
            foreach ($datas as $data) {
                $perms = array_merge_recursive($perms, $data['perms']);
            }
            $layer = Category::toLayer($perms);
            $perms = Category::proMenu($layer);
            session(['perms'=>$perms]);
        }
        return view('admin.home.home');
    }
}
