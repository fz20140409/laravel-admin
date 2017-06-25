@extends('admin.layouts.default')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        {{--<h3 class="box-title">用户列表</h3>

                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>--}}
                        {{--<div class="col-md-10">
                            <input type="text">
                        </div>--}}
                        <div class="col-md-2 col-md-offset-10">
                            <a href="{{route('admin.permission.create')}}" class="btn btn-primary" href="">新增</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th>ID</th>
                                <th>菜单名称</th>
                                <th>路由</th>
                                <th>描述</th>
                                <th>操作</th>
                            </tr>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$permission['id']}}</td>
                                    <td>{{$permission['delimiter'].$permission['display_name']}}</td>
                                    <td>{{$permission['name']}}</td>
                                    <td>{{$permission['description']}}</td>
                                    <td>
                                        <a href="{{route('admin.permission.edit',$permission['id'])}}"
                                           style="margin-right: 10px"><i class="fa fa-pencil-square-o "
                                                                         aria-hidden="true">修改</i></a>
                                        <a href="javascript:del('{{route('admin.permission.destroy',$permission['id'])}}')"><i
                                                    class="fa  fa-trash-o " aria-hidden="true">删除</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="/plugins/layer/layer.js"></script>
    <script>
        function del(url) {
            layer.confirm('确认删除？', {
                btn: ['确认', '取消']
            }, function () {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function ($data) {
                        //有子菜单
                        if ($data.msg == -1) {
                            layer.confirm('是否同时删除子菜单？', {
                                btn: ['确认', '取消']
                            }, function () {
                                $.ajax({
                                    url: url + '?flag=1',
                                    type: 'DELETE',
                                    success: function ($data) {
                                        if ($data.msg == 1) {
                                            layer.alert('删除成功');
                                            location.reload();
                                        } else {
                                            layer.alert('删除失败');
                                        }
                                    }
                                });
                            });
                        }
                        //无子菜单
                        if ($data.msg == 1) {
                            layer.alert('删除成功');
                            location.reload();
                        } else {
                            layer.alert('删除失败');
                        }


                    }
                });
            });
        }
    </script>

@endsection