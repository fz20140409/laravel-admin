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
        ]);
        DB::table('permissions')->insert([
            'id'=>3,
            'pid'=>1,
            'name'=>trim('admin.role.index'),
            'url'=>'route#admin.role.index#',
            'display_name'=>'角色',
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
            'display_name'=>'显示新增页',
        ]);
        DB::table('permissions')->insert([
            'id'=>6,
            'pid'=>2,
            'name'=>trim('admin.user.edit'),
            'ishow'=>0,
            'display_name'=>'显示修改页',
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
            'display_name'=>'显示权限页',
        ]);
        DB::table('permissions')->insert([
            'id'=>14,
            'pid'=>0,
            'name'=>trim('admin.home'),
            'url'=>'route#admin.home#',
            'icon'=>'fa fa-home',
            'ishow'=>1,
            'display_name'=>'主页',
        ]);
        DB::table('permissions')->insert([
            'id'=>15,
            'pid'=>8,
            'name'=>trim('admin.logs.index'),
            'url'=>'route#admin.logs.index#',
            'ishow'=>1,
            'display_name'=>'日志分析',
        ]);
        DB::table('permissions')->insert([
            'id'=>16,
            'pid'=>8,
            'name'=>trim('admin.task.index'),
            'url'=>'route#admin.task.index#',
            'ishow'=>1,
            'display_name'=>'定时任务',
        ]);
        DB::table('permissions')->insert([
            'id'=>17,
            'pid'=>16,
            'name'=>trim('admin.task.create'),
            'ishow'=>0,
            'display_name'=>'显示新增页',
        ]);
        DB::table('permissions')->insert([
            'id'=>18,
            'pid'=>16,
            'name'=>trim('admin.task.edit'),
            'ishow'=>0,
            'display_name'=>'显示修改页',
        ]);
        DB::table('permissions')->insert([
            'id'=>19,
            'pid'=>16,
            'name'=>trim('admin.task.destroy'),
            'ishow'=>0,
            'display_name'=>'删除',
        ]);
        DB::table('permissions')->insert([
            'id'=>20,
            'pid'=>16,
            'name'=>trim('admin.task.batch_destroy'),
            'ishow'=>0,
            'display_name'=>'批量删除',
        ]);
        DB::table('permissions')->insert([
            'id'=>21,
            'pid'=>16,
            'name'=>trim('admin.task.show'),
            'ishow'=>0,
            'display_name'=>'查看',
        ]);
        DB::table('permissions')->insert([
            'id'=>22,
            'pid'=>16,
            'name'=>trim('admin.task.store'),
            'ishow'=>0,
            'display_name'=>'新增操作',
        ]);
        DB::table('permissions')->insert([
            'id'=>23,
            'pid'=>16,
            'name'=>trim('admin.task.run'),
            'ishow'=>0,
            'display_name'=>'开启和关闭任务',
        ]);
        DB::table('permissions')->insert([
            'id'=>24,
            'pid'=>16,
            'name'=>trim('admin.task.update'),
            'ishow'=>0,
            'display_name'=>'修改操作',
        ]);
        DB::table('permissions')->insert([
            'id'=>25,
            'pid'=>2,
            'name'=>trim('admin.user.store'),
            'ishow'=>0,
            'display_name'=>'新增',
        ]);
        DB::table('permissions')->insert([
            'id'=>26,
            'pid'=>2,
            'name'=>trim('admin.user.update'),
            'ishow'=>0,
            'display_name'=>'修改',
        ]);

        DB::table('permissions')->insert([
            'id'=>27,
            'pid'=>3,
            'name'=>trim('admin.role.create'),
            'ishow'=>0,
            'display_name'=>'显示新增页',
        ]);
        DB::table('permissions')->insert([
            'id'=>28,
            'pid'=>3,
            'name'=>trim('admin.role.edit'),
            'ishow'=>0,
            'display_name'=>'显示修改页',
        ]);
        DB::table('permissions')->insert([
            'id'=>29,
            'pid'=>0,
            'name'=>trim('admin.home.flushCache'),
            'ishow'=>0,
            'display_name'=>'更新缓存',
        ]);
        DB::table('permissions')->insert([
            'id'=>30,
            'pid'=>3,
            'name'=>trim('admin.role.store'),
            'ishow'=>0,
            'display_name'=>'新增',
        ]);
        DB::table('permissions')->insert([
            'id'=>31,
            'pid'=>3,
            'name'=>trim('admin.role.update'),
            'ishow'=>0,
            'display_name'=>'修改',
        ]);
        DB::table('permissions')->insert([
            'id'=>33,
            'pid'=>3,
            'name'=>trim('admin.role.show'),
            'ishow'=>0,
            'display_name'=>'查看',
        ]);
        DB::table('permissions')->insert([
            'id'=>34,
            'pid'=>3,
            'name'=>trim('admin.role.destroy'),
            'ishow'=>0,
            'display_name'=>'删除',
        ]);
        DB::table('permissions')->insert([
            'id'=>35,
            'pid'=>3,
            'name'=>trim('admin.role.doPermission'),
            'ishow'=>0,
            'display_name'=>'授权',
        ]);
        DB::table('permissions')->insert([
            'id'=>36,
            'pid'=>4,
            'name'=>trim('admin.permission.create'),
            'ishow'=>0,
            'display_name'=>'显示新增页',
        ]);
        DB::table('permissions')->insert([
            'id'=>37,
            'pid'=>4,
            'name'=>trim('admin.permission.edit'),
            'ishow'=>0,
            'display_name'=>'显示修改页',
        ]);
        DB::table('permissions')->insert([
            'id'=>38,
            'pid'=>4,
            'name'=>trim('admin.permission.store'),
            'ishow'=>0,
            'display_name'=>'新增',
        ]);
        DB::table('permissions')->insert([
            'id'=>39,
            'pid'=>4,
            'name'=>trim('admin.permission.update'),
            'ishow'=>0,
            'display_name'=>'修改',
        ]);
        DB::table('permissions')->insert([
            'id'=>40,
            'pid'=>4,
            'name'=>trim('admin.permission.show'),
            'ishow'=>0,
            'display_name'=>'查看',
        ]);
        DB::table('permissions')->insert([
            'id'=>41,
            'pid'=>4,
            'name'=>trim('admin.permission.destroy'),
            'ishow'=>0,
            'display_name'=>'删除',
        ]);




    }
}
