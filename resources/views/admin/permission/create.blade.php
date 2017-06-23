@extends('admin.layouts.default')
@section('css')
    <link rel="stylesheet" href="/adminlte/plugins/iCheck/all.css">
@endsection
@section('js')
    <script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script>
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    </script>
@endsection
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">权限</h3>
                    </div>
                    <!-- /.box-header -->
                @include('admin.common.alert')
                <!-- form start -->
                    <form class="form-horizontal" method="post"
                          action="@if(isset($permission)){{ route('admin.user.update',$permission) }}@else{{ route('admin.user.store') }}@endif">
                        {{csrf_field()}}
                        @if(isset($permission)){{method_field('PUT')}}@endif
                        <div class="box-body">
                            <div class="form-group">
                                <label for="pid" class="col-sm-2 control-label">上级菜单</label>

                                <div class="col-sm-10">
                                    <select name="pid" class="form-control" id="pid" autofocus>
                                        <option value="0">一级菜单</option>
                                        @foreach($permissions as $perm)
                                            <option value="{{$perm['id']}}">{{$perm['delimiter'].$perm['display_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="display_name" class="col-sm-2 control-label">名称菜单</label>

                                <div class="col-sm-10">
                                    <input name="display_name"
                                           value="@if(isset($permission)){{$permission->email}}@else{{old('display_name')}}@endif"
                                           type="text" class="form-control" id="display_name" placeholder="名称菜单"
                                           required>
                                    @if ($errors->has('display_name'))
                                        <div class="alert alert-warning">{{ $errors->first('display_name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">路由</label>

                                <div class="col-sm-10">
                                    <input name="name" type="text" class="form-control" id="name" placeholder="路由"
                                           required>
                                    @if ($errors->has('password'))
                                        <div class="alert alert-warning">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="icon" class="col-sm-2 control-label">图标</label>

                                <div class="col-sm-10">
                                    <input name="icon" type="text" class="form-control" id="icon" placeholder="图标">
                                    @if ($errors->has('password'))
                                        <div class="alert alert-warning">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">显示</label>

                                <div class="col-sm-10">
                                    <label>
                                        <input value="1" type="radio" name="ishow" class="minimal" checked>是
                                    </label>
                                    <label style="margin-left: 10px">
                                        <input value="0" type="radio" name="ishow" class="minimal">否
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-sm-2 control-label">描述</label>

                                <div class="col-sm-10">
                                    <textarea name="description" id="description" class="form-control" rows="3"
                                              placeholder="描述 ..."></textarea>


                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button onclick="history.go(-1)" class="btn btn-default">取消</button>
                            <button type="submit" class="btn btn-info pull-right">保存</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection