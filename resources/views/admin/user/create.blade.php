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
                    <h3 class="box-title">xx</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{ route('admin.user.store') }}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">邮箱</label>

                            <div class="col-sm-10">
                                <input name="email" value="{{old('email')}}" type="email" class="form-control" id="email" placeholder="邮箱" required autofocus>
                            </div>
                        </div>
                        @if ($errors->has('email'))
                            <div class="alert alert-warning">{{ $errors->first('email') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label">密码</label>

                            <div class="col-sm-10">
                                <input name="password" type="password" class="form-control" id="password" placeholder="密码" required>
                            </div>
                        </div>
                        @if ($errors->has('password'))
                            <div class="alert alert-warning">{{ $errors->first('password') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="password-confirm" class="col-sm-2 control-label">确认密码</label>

                            <div class="col-sm-10">
                                <input name="password_confirmation" required  type="password" class="form-control" id="password-confirm" placeholder="确认密码">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">昵称</label>

                            <div class="col-sm-10">
                                <input value="{{old('name')}}" name="name" type="text" class="form-control" id="name" placeholder="昵称" required>
                            </div>
                        </div>
                        @if ($errors->has('name'))
                            <div class="alert alert-warning">{{ $errors->first('name') }}</div>
                        @endif
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label">角色</label>
                            <div class="col-sm-10">

                            <label>
                                <input type="checkbox" class="minimal">普通管理员
                            </label>
                            <label>
                                <input type="checkbox" class="minimal">超级管理员
                            </label>

                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-default">取消</button>
                        <button type="submit" class="btn btn-info pull-right">保存</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        </div>
    </section>
    @endsection