<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //定义每页显示几条
        $page_sizes = ['10' => 10, '25' => 25, '50' => 50, '100' => 100];
        $command_types = [1 => 'laravel命令', 2 => '系统命令'];
        $is_runs = [0 => '关闭任务', 1 => '开启任务'];
        $is_wols = [0 => '不允许', 1 => '允许'];
        isset($request->page_size) ? $page_size = $request->page_size : $page_size = 10;
        //条件
        $where_str = $request->where_str;
        $where = array();

        if (isset($where_str)) {
            $where[] = ['name', 'like', '%' . $where_str . '%'];

        }
        //分页
        $tasks = Task::where($where)->paginate($page_size);
        //视图
        return view('admin.task.index', compact(['tasks', 'where_str', 'page_size', 'page_sizes', 'command_types','is_runs','is_wols']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.task.create');
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
        if (Task::create([
            'name' => $request->name,
            'minute' => empty($request->minute) ? '*' : $request->minute,
            'hour' => empty($request->hour) ? '*' : $request->hour,
            'day' => empty($request->day) ? '*' : $request->day,
            'month' => empty($request->month) ? '*' : $request->month,
            'week' => empty($request->week) ? '*' : $request->week,
            'command_type' => $request->command_type,
            'command' => $request->command,
            'is_wol' => $request->is_wol,
            'is_eimm' => $request->is_eimm,
            'description' => $request->description,
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
        $task = Task::findOrFail($id);


        return view('admin.task.create', compact(['task']));
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    protected function validator(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string',
            'minute' => 'nullable|required|string',
            'hour' => 'nullable|required|string',
            'day' => 'nullable|required|string',
            'month' => 'nullable|required|string',
            'week' => 'nullable|string',
            'command_type' => 'required',
            'command' => 'required|string',
            'is_wol' => 'required',
            'is_eimm' => 'required',
        ])->validate();
    }

    public function run($id)
    {
       $task=Task::find($id);
       if($task){
           $task->is_run=1;
           $task->save();
           return response()->json([
               'msg' => 1
           ]);

       }else{
           return response()->json([
               'msg' => 0
           ]);
       }

    }
}
