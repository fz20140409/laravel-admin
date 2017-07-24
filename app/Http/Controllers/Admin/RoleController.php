<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Tools\Category;
use App\Role;
use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


      /*  $roles = Role::paginate(10);
        return view('admin.role.index', compact('roles'));*/
        //条件
        $where_str = $request->where_str;
        $where = array();
        $orWhere = array();
        if (isset($where_str)) {
            $where[] = ['name', 'like', '%' . $where_str . '%'];
            $orWhere[] = ['display_name', 'like', '%' . $where_str . '%'];
        }

        //分页
        $roles = Role::where($where)->orWhere($orWhere)->paginate($this->page_size);
        //视图
        return view('admin.role.index', ['roles' => $roles, 'where_str' => $where_str, 'page_size' => $this->page_size, 'page_sizes' => $this->page_sizes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }

    public function permission(Request $request, $id)
    {
        //获取角色的权限
        $role = Role::findOrFail($id);
        $arr = $role->perms()->get()->toArray();
        $role_permissions = array();
        foreach ($arr as $value) {
            $role_permissions[] = $value['pivot']['permission_id'];
        }
        //获取所有权限
        $permissions = Permission::all()->toArray();
        $permissions = Category::toLevel($permissions, 0, '&nbsp;&nbsp;&nbsp;&nbsp;');


        return view('admin.role.permission', compact(['permissions', 'id', 'role_permissions']));
    }

    public function doPermission(Request $request)
    {
        $role_id = intval($request->role_id);
        $permission_ids = $request->permission_ids;
        if (empty($permission_ids)) {
            return response()->json([
                'msg' => '请选择权限'
            ]);
        }
        $role = Role::findOrFail($role_id);
        DB::beginTransaction();
        try {
            $role->perms()->sync($permission_ids);
            DB::commit();
            return response()->json([
                'msg' => '授权成功'
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'msg' => '授权失败'
            ]);
        }
    }
    public function batch_destroy(Request $request){

    }
}
