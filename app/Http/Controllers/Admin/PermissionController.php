<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Tools\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PermissionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $permissions = Permission::all()->toArray();
        $permissions = Category::toLevel($permissions);

        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissions = Permission::all()->toArray();
        $permissions = Category::toLevel($permissions);

        return view('admin.permission.create', compact(['permissions']));
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
        $this->validator($request);
        if (Permission::create([
            'name' => $request->name,
            'pid' => $request->pid,
            'icon' => $request->icon,
            'ishow' => $request->ishow,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'url' => $request->url,
        ])
        ) {
            return redirect()->back()->with('success', '添加成功');
        } else {
            return redirect()->back()->with('error', '添加失败');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
        $permissions = Permission::all()->toArray();
        $permissions = Category::toLevel($permissions);

        return view('admin.permission.create', compact(['permissions', 'permission']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        //

        $this->validator($request,$permission);
        if ($permission->update([
            'name' => $request->name,
            'pid' => $request->pid,
            'icon' => $request->icon,
            'ishow' => $request->ishow,
            'display_name' => $request->display_name,
            'description' => $request->description,
            'url' => $request->url,
        ])
        ) {
            return redirect()->back()->with('success', '更新成功');
        } else {
            return redirect()->back()->with('error', '更新失败');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission, Request $request)
    {

        $permissions = Permission::all()->toArray();
        $sub_permissions = Category::toLevel($permissions, $permission->id);
        $sub = array();
        //有子菜单
        if (!empty($sub_permissions)) {
            if (!$request->flag) {
                return response()->json(['msg' => -1]);
            }
            //确认删除子菜单

            foreach ($sub_permissions as $sub_permission) {
                $sub[] = $sub_permission['id'];
            }
            $sub[] = $permission->id;
        }else{
            //无子菜单
            $sub=$permission->id;
        }
        DB::beginTransaction();
        try {
            Permission::destroy($sub);

            $permission->roles()->detach($sub);
            DB::commit();
            return response()->json([
                'msg' => 1
            ]);
        } catch (\Exception $exception) {
            print_r($exception->getMessage());
            DB::rollBack();
            return response()->json([
                'msg' => 0
            ]);
        }


    }

    protected function validator(Request $request,Permission $permission)
    {
        return Validator::make($request->all(), [
            'pid' => 'required|integer',
            'display_name' => 'required|string',
            'name' => "required|string|unique:permissions,name,$permission->id",
            'url' => 'nullable|string',
            'ishow' => 'required|integer',
        ])->validate();

    }
}
