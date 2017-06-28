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
           'name'=>trim('admin.rbac'),
           'display_name'=>'权限管理',
           'icon'=>'fa fa-lock',
       ]);
        DB::table('permissions')->insert([
            'id'=>2,
            'pid'=>1,
            'name'=>trim('admin.user.index'),
            'url'=>'route#admin.user.index#',
            'display_name'=>'用户',
            'icon'=>'fa fa-user',
        ]);
        DB::table('permissions')->insert([
            'id'=>3,
            'pid'=>1,
            'name'=>trim('admin.role.index'),
            'url'=>'route#admin.role.index#',
            'display_name'=>'角色',
            'icon'=>'fa fa-users',
        ]);
        DB::table('permissions')->insert([
            'id'=>4,
            'pid'=>1,
            'name'=>trim('admin.permission.index'),
            'url'=>'route#admin.permission.index#',
            'display_name'=>'权限',
        ]);
        DB::table('permissions')->insert([
            'id'=>5,
            'pid'=>2,
            'name'=>trim('admin.user.create'),
            'ishow'=>0,
            'display_name'=>'增加',
        ]);
        DB::table('permissions')->insert([
            'id'=>6,
            'pid'=>2,
            'name'=>trim('admin.user.edit'),
            'ishow'=>0,
            'display_name'=>'修改',
        ]);
        DB::table('permissions')->insert([
            'id'=>8,
            'pid'=>0,
            'name'=>trim('admin.tools'),
            'ishow'=>1,
            'icon'=>'fa fa-wrench',
            'display_name'=>'工具',
        ]);
        DB::table('permissions')->insert([
            'id'=>9,
            'pid'=>8,
            'name'=>trim('admin.builder'),
            'url'=>'route#admin.builder.index#',
            'ishow'=>1,
            'display_name'=>'生成器',
        ]);
        DB::table('permissions')->insert([
            'id'=>10,
            'pid'=>2,
            'name'=>trim('admin.user.destroy'),
            'ishow'=>0,
            'display_name'=>'删除',
        ]);
        DB::table('permissions')->insert([
            'id'=>11,
            'pid'=>2,
            'name'=>trim('admin.user.batch_destroy'),
            'ishow'=>0,
            'display_name'=>'批量删除',
        ]);
        DB::table('permissions')->insert([
            'id'=>12,
            'pid'=>2,
            'name'=>trim('admin.user.show'),
            'ishow'=>0,
            'display_name'=>'查看',
        ]);
        DB::table('permissions')->insert([
            'id'=>13,
            'pid'=>3,
            'name'=>trim('admin.role.permission'),
            'ishow'=>0,
            'display_name'=>'权限',
        ]);
        DB::table('permissions')->insert([
            'id'=>14,
            'pid'=>0,
            'name'=>trim('admin.home'),
            'icon'=>'fa fa-home',
            'ishow'=>0,
            'display_name'=>'后台主页',
        ]);


    }
}
