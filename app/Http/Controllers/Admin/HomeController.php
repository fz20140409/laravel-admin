<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Tools\Category;
use App\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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

        $perms ='';
        $user_id = Auth::id();
        $session_key='user'.$user_id;
        //没有缓存
        if(!session()->has($session_key)){
        $roles = DB::table('role_user')->where(['user_id' => $user_id])->get();
        if (!empty($roles)) {
            $role_ids = array();
            foreach ($roles as $role) {
                $role_ids[] = $role->role_id;
            }
            $permissions = DB::table('permission_role')->whereIn('role_id', $role_ids)->get();
            if (!empty($permissions)) {
                $permission_ids = array();
                foreach ($permissions as $permission) {
                    $permission_ids[] = $permission->permission_id;
                }
                $perms =Permission::whereIn('id', $permission_ids)->where(['ishow'=>1])->get()->toArray();
            }

        }


        if (!empty($perms)) {
            $layer = Category::toLayer($perms);
            $perms = Category::proMenu($layer);
        }

            session(["$session_key"=>$perms]);
        }
        return view('admin.home.home');
    }


}
