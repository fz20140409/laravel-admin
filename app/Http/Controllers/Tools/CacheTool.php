<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Permission;
use App\Http\Controllers\Tools\Category;
use Illuminate\Support\Facades\Cache;

class CacheTool
{
    static function cacheMneu($key)
    {
        $perms = '';
        $roles = DB::table('role_user')->where(['user_id' => Auth::id()])->get();
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
                $perms = Permission::whereIn('id', $permission_ids)->where(['ishow' => 1])->get()->toArray();
            }
        }
        if (!empty($perms)) {
            $layer = Category::toLayer($perms);
            $perms = Category::proMenu($layer);
        }
        Cache::forever($key, $perms);


    }


}
