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
           'name'=>'admin.login',
           'display_name'=>'权限管理',
       ]);
        DB::table('permissions')->insert([
            'id'=>2,
            'pid'=>1,
            'name'=>'admin.user.index',
            'display_name'=>'用户',
        ]);
        DB::table('permissions')->insert([
            'id'=>3,
            'pid'=>1,
            'name'=>'admin.role.index',
            'display_name'=>'角色',
        ]);
        DB::table('permissions')->insert([
            'id'=>4,
            'pid'=>1,
            'name'=>'admin.permission.index',
            'display_name'=>'权限',
        ]);
        DB::table('permissions')->insert([
            'id'=>5,
            'pid'=>2,
            'name'=>'admin.user.create',
            'display_name'=>'增加',
        ]);
        DB::table('permissions')->insert([
            'id'=>6,
            'pid'=>2,
            'name'=>'admin.logout',
            'display_name'=>'修改',
        ]);


    }
}
