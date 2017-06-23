<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Tools\Category;
use App\Permission;
use Illuminate\Support\Facades\Auth;
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

        $user_id = Auth::id();
        $roles = DB::table('role_user')->where(['user_id' => $user_id])->get();
        $perms ='';
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
            $perms = Category::proMenu($perms);
        }
        return view('admin.home.home', compact('perms'));
    }

    public function __construct()
    {
        $this->middleware('admin_auth');
    }

}
