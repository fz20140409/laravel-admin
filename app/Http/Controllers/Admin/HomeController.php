<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Tools\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

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
            session(['perms' => $perms]);
        }
        return view('admin.home.home');
    }

    public function flushCache()
    {
        Cache::tags(Config::get('entrust.role_user_table'))->flush();
        Cache::tags(Config::get('entrust.permission_role_table'))->flush();
        return response()->json(['status' => 1]);

    }

}
