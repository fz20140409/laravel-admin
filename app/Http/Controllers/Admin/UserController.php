<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //定义每页显示几条
        $page_sizes=['10'=>10,'25'=>25,'50'=>50,'100'=>100];
        isset($request->page_size)?$page_size=$request->page_size:$page_size=10;
        $where_str = $request->where;
        $where = array();
        $orWhere = array();
        if (isset($where_str)) {
            $where[] = ['email', 'like', '%' . $where_str . '%'];
            $orWhere[] = ['name', 'like', '%' . $where_str . '%'];
        }

        $users = User::where($where)->orWhere($orWhere)->paginate($page_size);
        return view('admin.user.index', compact(['users', 'where_str','page_size','page_sizes']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::all();
        return view('admin.user.create', compact(['roles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        $role_ids = $request->role_ids;
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            if ($user && !empty($role_ids)) {
                $user->roles()->sync($role_ids);
            }
            DB::commit();
            return redirect()->back()->with('success', '添加成功');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', '添加失败');
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.user.create', compact(['user', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,$user->id",
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        $role_ids = $request->role_ids;
        DB::beginTransaction();
        try {
            $data = ['name' => $request->name, 'email' => $request->email];
            //不填密码，不更新原密码
            if (!empty($request->password)) {
                $data['password'] = $request->password;
            }
            $user->update($data);
            if (!empty($role_ids)) {
                $user->roles()->sync($role_ids);
            }
            DB::commit();
            return redirect()->back()->with('success', '更新成功');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', '更新失败');
        }

    }

    /**
     * 异步删除
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->delete();
            $user->roles()->detach($id);
            DB::commit();
            return response()->json([
                'msg' => 1
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'msg' => 0
            ]);

        }
    }

    public function batch_destroy(Request $request)
    {
        $user_ids = $request->user_ids;
        //检查是空，并且是否为数组
        if (empty($user_ids)&&!is_array($user_ids)) {
            return response()->json([
                'msg' => 0
            ]);
        }
        //检查是否数组的每个值是否为整数
        foreach ($user_ids as $user_id) {
            if (!preg_match("/^[0-9]*$/", $user_id)) {
                return response()->json([
                    'msg' => 0
                ]);
            }
        }
        //判定表的记录数和传递的一致
        if (User::whereIn('id', $user_ids)->count() != count($user_ids)) {
            return response()->json([
                'msg' => 0
            ]);
        };
        DB::beginTransaction();
        try {
            User::destroy($user_ids);
            DB::table('role_user')->whereIn('user_id',$user_ids)->delete();
            DB::commit();
            return response()->json([
                'msg' => 1
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'msg' => 0
            ]);
        }

    }

}
