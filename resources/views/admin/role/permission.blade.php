@extends('admin.layouts.default')
@section('t1','角色')
@section('t2','权限')
@section('css')
    <link rel="stylesheet" href="/adminlte/plugins/iCheck/all.css">
@endsection
@section('js')
    <script src="/plugins/layer/layer.js"></script>
    <script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script>
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    </script>
    <script>
        //全选
        $('#all').on('ifChecked', function () {
            $('table input[type="checkbox"]').iCheck('check');
        });
        //反选
        $('#notall').on('ifChecked', function () {
            $('table input[type="checkbox"]').each(function () {
                if ($(this).is(":checked")) {
                    $(this).iCheck('uncheck');
                } else {
                    $(this).iCheck('check');
                }
            });
        });
        //全不选
        $('#allnot').on('ifChecked', function () {
            $('table input[type="checkbox"]').iCheck('uncheck');
        });
        $('table input[type="checkbox"]').each(function () {
            $(this).on('ifChecked', function () {
                var pid = $(this).attr('pid');
                $('table input[type="checkbox"][value="' + pid + '"]').iCheck('check');

            });
            $(this).on('ifUnchecked', function () {
                var pid = $(this).attr('pid');
                $('table input[type="checkbox"][value="' + pid + '"]').iCheck('uncheck');
            });


        })
    </script>
    <script>
        function save(url) {
            $.ajax({
                    type: 'POST',
                    url: url,
                    data:$("#form").serialize(),
                    dataType: "json",
                    success: function ($data) {
                        layer.alert($data.msg);
                    }

                }
            );
        }
    </script>
@endsection
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-default">
                    <div class="row box-header">
                        <div class="col-sm-10">
                            <div class="form-group">
                                <label>
                                    <input name="r1" type="radio" id="all" class="minimal">全选
                                </label>
                                <label style="margin-left: 10px">
                                    <input name="r1" type="radio" id="notall" class="minimal">反选
                                </label>
                                <label style="margin-left: 10px">
                                    <input name="r1" type="radio" id="allnot" class="minimal">全不选
                                </label>
                            </div>
                        </div>


                    </div>
                    <div class="box-body table-responsive no-padding">
                        <form id="form">
                            <table class="table table-hover table-bordered">
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>
                                            <label>
                                                <input @if(in_array($permission['id'],$role_permissions)) checked @endif
                                                        pid="{{$permission['pid']}}" value="{{$permission['id']}}"
                                                       name="permission_ids[]" type="checkbox" class="minimal">
                                            </label>
                                        </td>
                                        <td>{{$permission['delimiter'].$permission['display_name']}}</td>
                                        <td>{{$permission['name']}}</td>
                                        <td>{{$permission['description']}}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <input name="role_id" value="{{$id}}" type="hidden">
                        </form>
                    </div>
                    <div class="box-footer">
                        <button onclick="history.go(-1)" class="btn btn-default">取消</button>
                        <a href="javascript:save('{{route('admin.role.doPermission')}}')" class="btn btn-primary pull-right">保存</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection