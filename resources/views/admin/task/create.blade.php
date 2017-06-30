@extends('admin.layouts.default')
@section('css')
    <link rel="stylesheet" href="/adminlte/plugins/iCheck/all.css">
@endsection
@section('js')
    <script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script>
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue',
        });
    </script>
    @include('admin.common.layer_tip')
@endsection
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <!-- form start -->
                    @if(isset($show))
                        <fieldset disabled>@endif
                            <form class="box-header form-horizontal" method="post"
                                  action="@if(isset($task)){{ route('admin.user.update',$task) }}@else{{ route('admin.task.store') }}@endif">
                                {{csrf_field()}}
                                @if(isset($task)){{method_field('PUT')}}@endif
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">任务名称</label>

                                        <div class="col-sm-8">
                                            <input name="name"
                                                   value="@if(isset($task)){{$task->name}}@else{{old('name')}}@endif"
                                                   type="text" class="form-control" id="name" placeholder="任务名称"
                                                   required autofocus>
                                            @if ($errors->has('name'))
                                                <div class="alert alert-warning">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="minute" class="col-sm-2 control-label">分钟</label>

                                        <div class="col-sm-8">

                                            <input name="minute"
                                                   value="@if(isset($task)){{$task->minute}}@else{{old('minute')}}@endif"
                                                   type="text" class="form-control" id="minute" placeholder="0-59数字和* - , /的组合"
                                                   >
                                            @if ($errors->has('minute'))
                                                <div class="alert alert-warning">{{ $errors->first('minute') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="hour" class="col-sm-2 control-label">小时</label>

                                        <div class="col-sm-8">
                                            <input name="hour"
                                                   value="@if(isset($task)){{$task->hour}}@else{{old('hour')}}@endif"
                                                   type="text" class="form-control" id="hour" placeholder="0-23数字和* - , /的组合" >
                                            @if ($errors->has('hour'))
                                                <div class="alert alert-warning">{{ $errors->first('hour') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="day" class="col-sm-2 control-label">天</label>

                                        <div class="col-sm-8">
                                            <input name="day"
                                                   value="@if(isset($task)){{$task->day}}@else{{old('day')}}@endif"
                                                   type="text" class="form-control" id="day" placeholder="1-31数字和* - , /的组合" >
                                            @if ($errors->has('day'))
                                                <div class="alert alert-warning">{{ $errors->first('day') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="month" class="col-sm-2 control-label">月份</label>

                                        <div class="col-sm-8">
                                            <input name="month"
                                                   value="@if(isset($task)){{$task->month}}@else{{old('month')}}@endif"
                                                   type="text" class="form-control" id="month" placeholder="1-12数字和* - , /的组合"
                                                   >
                                            @if ($errors->has('month'))
                                                <div class="alert alert-warning">{{ $errors->first('month') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="week" class="col-sm-2 control-label">星期几</label>

                                        <div class="col-sm-8">
                                            <input name="week"
                                                   value="@if(isset($task)){{$task->week}}@else{{old('week')}}@endif"
                                                   type="text" class="form-control" id="week" placeholder="0-7数字和* - , /的组合"
                                                   >
                                            @if ($errors->has('week'))
                                                <div class="alert alert-warning">{{ $errors->first('week') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="command_type" class="col-sm-2 control-label">命令的类型</label>

                                        <div class="col-sm-8">
                                            <select id="command_type" name="command_type" class="form-control">
                                                <option value="1">laravel命令</option>
                                                <option value="2">系统命令</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="command" class="col-sm-2 control-label">执行的命令</label>

                                        <div class="col-sm-8">
                                            <input name="command"
                                                   value="@if(isset($task)){{$task->command}}@else{{old('command')}}@endif"
                                                   type="text" class="form-control" id="command" placeholder="执行的命令"
                                                   required>
                                            @if ($errors->has('command'))
                                                <div class="alert alert-warning">{{ $errors->first('command') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">是否允许任务重复</label>
                                        <div class="col-sm-8">
                                            <label style="margin-top: 6px;margin-right: 20px">
                                                <input name="is_wol" value="1" type="radio" class="minimal" checked>是
                                            </label>
                                            <label>
                                                <input name="is_wol" value="0" type="radio" class="minimal">否
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">维护模式是否强制执行</label>
                                        <div class="col-sm-8">
                                            <label style="margin-top: 6px;margin-right: 20px">
                                                <input name="is_eimm" value="1" type="radio" class="minimal" >是

                                            </label>
                                            <label>
                                                <input name="is_eimm" value="0" type="radio" class="minimal" checked>否
                                            </label>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="col-sm-2 control-label">任务描述</label>

                                        <div class="col-sm-8">
                                            <textarea id="description" name="description"
                                                      class="form-control"></textarea>
                                            @if ($errors->has('任务描述'))
                                                <div class="alert alert-warning">{{ $errors->first('任务描述') }}</div>
                                            @endif
                                        </div>
                                    </div>


                                    {{--<div class="form-group">
                                        <label for="inputPassword3" class="col-sm-2 control-label">角色</label>
                                        <div class="col-sm-8">
                                        @foreach($roles as $role)

                                        <label style="margin-top: 6px">
                                            @if(isset($show))
                                                @if(isset($user)&&$user->hasRole($role->name)) {{$role->display_name}} @endif
                                            @else
                                                <input @if(isset($user)&&$user->hasRole($role->name)) checked @endif value="{{$role->id}}" name="role_ids[]" type="checkbox" class="minimal">{{$role->display_name}}
                                            @endif
                                        </label>
                                            @endforeach
                                        </div>
                                    </div>--}}
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer  @if(isset($show)) hidden @endif">
                                    <a href="{{route('admin.task.index')}}" class="btn btn-default">返回</a>
                                    <button type="submit" class="btn btn-primary pull-right">保存</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                            @if(isset($show))</fieldset>@endif
                </div>
            </div>
        </div>
    </section>
@endsection