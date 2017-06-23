<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;


class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::paginate(10);
        return view('admin.user.index', compact(['users']));
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

}
