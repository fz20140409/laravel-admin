@extends('admin.layouts.default')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">

                    <div class="row box-header">
                        <div class="col-md-10">
                            <form class="form-inline" action="{{route('admin.user.index')}}">
                                <div class="form-group">
                                    <span style="margin-right: 5px">每页</span>
                                    <select name="page_size" class="form-control">
                                        @foreach($page_sizes as $k=> $v)
                                            <option @if($page_size==$k) selected @endif value="{{$k}}">{{$v}}</option>
                                            @endforeach
                                    </select>
                                    <span style="margin:0 25px 0px 5px">条</span>

                                </div>
                                <div class="form-group">
                                    <input value="{{$where_str}}" name="where" type="text" class="form-control"
                                           placeholder="邮箱/昵称">
                                </div>
                                <button type="submit" class="btn btn-primary">查询</button>
                            </form>
                        </div>
                        @if(Auth::user()->can('admin.user.create'))
                            <div class="col-md-2">
                                <a href="{{route('admin.user.create')}}" class="btn btn-primary" href="">新增</a>
                            </div>
                        @endif
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <form id="user_ids">
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>邮箱</th>
                                    <th>昵称</th>
                                    <th>最后登录ip</th>
                                    <th>最后登录时间</th>
                                    <th>操作</th>
                                </tr>
                                @foreach($users as $user)
                                    <tr>
                                        <th><input class="minimal" name="user_ids[]" type="checkbox" value="{{$user->id}}"></th>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{long2ip($user->ip)}}</td>
                                        <td>{{$user->last_time}}</td>
                                        <td>
                                            <a href="{{route('admin.user.show',$user->id)}}"
                                               style="margin-right: 10px"><i
                                                        class="fa fa-eye " aria-hidden="true">查看</i></a>
                                            @if(Auth::user()->can('admin.user.edit'))
                                                <a href="{{route('admin.user.edit',$user->id)}}"
                                                   style="margin-right: 10px"><i
                                                            class="fa fa-pencil-square-o " aria-hidden="true">修改</i></a>
                                            @endif
                                            @if(Auth::user()->can('admin.user.destroy'))
                                                <a href="javascript:del('{{route('admin.user.destroy',$user->id)}}')"><i
                                                            class="fa  fa-trash-o " aria-hidden="true">删除</i></a>@endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </form>

                        <div class="box-footer ">
                            @if(Auth::user()->can('admin.user.batch_destroy'))
                            <div class="btn-group">
                                <button onclick="selectAll()" type="button" class="btn btn-default">全选</button>
                                <button onclick="reverse()" type="button" class="btn btn-default">反选</button>
                                <a href="javascript:batch_destroy()" class="btn btn-danger">批量删除</a>

                            </div>
                            @endif
                            <div style="float: right">
                                {{$users->appends(['where' => $where_str,'page_size'=>$page_size])->links()}}
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('css')
    <link rel="stylesheet" href="/adminlte/plugins/iCheck/all.css">
@endsection
@section('js')
    <script src="/plugins/layer/layer.js"></script>
    <script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script>
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    </script>
    <script>
        //批量删除
        function batch_destroy() {
            $cbs = $('table input[type="checkbox"]:checked');
            if ($cbs.length > 0) {
                $.ajax({
                    url: '{{route("admin.user.batch_destroy")}}',
                    type: 'post',
                    data: $("#user_ids").serialize(),
                    success: function (data) {
                        if (data.msg == 1) {
                            layer.alert('删除成功');
                            location.reload();
                        } else {
                            layer.alert('删除失败');
                        }

                    }
                });
            }else {
                layer.alert('请选中要删除的列');
            }
        }
        //全选
        function selectAll() {
            $('input[type="checkbox"].minimal').iCheck('check')
        }
        //反选
        function reverse() {
            $('input[type="checkbox"].minimal').each(function () {
               if($(this).is(":checked")){
                   $(this).iCheck('uncheck');
               }else {
                   $(this).iCheck('check');
               }
            });
        }
    </script>
    @include('admin.common.layer_del')
@endsection