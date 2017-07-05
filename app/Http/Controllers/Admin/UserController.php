<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        //条件
        $where_str = $request->where_str;
        $where = array();
        $orWhere = array();
        if (isset($where_str)) {
            $where[] = ['email', 'like', '%' . $where_str . '%'];
            $orWhere[] = ['name', 'like', '%' . $where_str . '%'];
        }

        //分页
        $users = User::where($where)->orWhere($orWhere)->paginate($this->page_size);
        //视图
        return view('admin.user.index',['users'=>$users, 'where_str'=>$where_str, 'page_size'=>$this->page_size, 'page_sizes'=>$this->page_sizes]);
    }

    public function create()
    {
        //
        $roles = Role::all();
        return view('admin.user.create', compact(['roles']));
    }

    /**
     * 新增
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     * 查看
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::all();
        $show = 1;

        return view('admin.user.create', compact(['user', 'roles', 'show']));
    }

    /**
     * 展示修改页面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('admin.user.create', compact(['user', 'roles']));
    }

    /**
     * 修改
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
                $data['password'] = bcrypt($request->password);
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
     * ajax删除
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

    /**
     *
     * ajax批量删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function batch_destroy(Request $request)
    {
        $user_ids = $request->user_ids;
        //检查是空，并且是否为数组
        if (empty($user_ids) && !is_array($user_ids)) {
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
            DB::table('role_user')->whereIn('user_id', $user_ids)->delete();
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
