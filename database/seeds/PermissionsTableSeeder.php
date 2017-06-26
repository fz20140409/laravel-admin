<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       DB::table('permissions')->insert([
           'id'=>1,
           'pid'=>0,
           'name'=>'admin.rbac',
           'display_name'=>'权限管理',
           'icon'=>'fa fa-lock',
       ]);
        DB::table('permissions')->insert([
            'id'=>2,
            'pid'=>1,
            'name'=>'admin.user.index',
            'url'=>'route#admin.user.index#',
            'display_name'=>'用户',
            'icon'=>'fa fa-user',
        ]);
        DB::table('permissions')->insert([
            'id'=>3,
            'pid'=>1,
            'name'=>'admin.role.index',
            'url'=>'route#admin.role.index#',
            'display_name'=>'角色',
            'icon'=>'fa fa-users',
        ]);
        DB::table('permissions')->insert([
            'id'=>4,
            'pid'=>1,
            'name'=>'admin.permission.index',
            'url'=>'route#admin.permission.index#',
            'display_name'=>'权限',
        ]);
        DB::table('permissions')->insert([
            'id'=>5,
            'pid'=>2,
            'name'=>'admin.user.create',
            'ishow'=>0,
            'display_name'=>'增加',
        ]);
        DB::table('permissions')->insert([
            'id'=>6,
            'pid'=>2,
            'name'=>' admin.user.edit',
            'ishow'=>0,
            'display_name'=>'修改',
        ]);


    }
}
