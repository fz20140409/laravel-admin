<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Tools\CacheTool;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
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
        $cache_key = 'user_menu_' . Auth::id();
        //没有缓存
        if (!Cache::get($cache_key)) {
            CacheTool::cacheMneu($cache_key);
        }
        if(Request::ajax()){
            //更新菜单缓存
            Cache::forget($cache_key);
            CacheTool::cacheMneu($cache_key);
            //更新
            Cache::tags(Config::get('entrust.role_user_table'))->flush();
            Cache::tags(Config::get('entrust.permission_role_table'))->flush();
            return response()->json(['status'=>1]);

        }
        return view('admin.home.home');
    }
}
