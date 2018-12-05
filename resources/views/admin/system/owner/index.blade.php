@extends('admin.layouts.main')
@section('title', '管理员列表-管理员管理-权限中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">管理员列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>用户名</label>
                                    <input type="text" name="name" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'name') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>电话</label>
                                    <input type="text" name="phone" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'phone') }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label></label>
                                    <input type="submit" name="submit" class="btn btn-block btn-primary" style="width: 100%;" value="搜索" />
                                </div>
                            </div>
                        </form>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="width: 10%;">
                                    用户ID
                                </th>
                                <th style="width: 10%;">
                                    用户名
                                </th>
                                <th style="width: 15%;">
                                    角色
                                </th>
                                <th>
                                    账号状况
                                </th>
                                <th style="width: 10%;">
                                    操作
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($list))
                                @foreach($list as $key => $value)
                                    <tr>
                                        <td>{{ $value['user_id'] }}</td>
                                        <td style="color:@if($value['is_owner'] == 1) green @else grey @endif">
                                            {{ $value['name'] }}
                                        </td>
                                        <td>
                                            @if(!empty($value['role_no'])){{ $value['role_name'] }}-{{ $value['role_no'] }}@endif<br>
                                            @if(!empty($value['indexTag']))入口地址：{{ $value['indexTag'] }}@endif<br>
                                        </td>
                                        <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                            创建时间：{{ $value['created_at'] }}<br>
                                            电话：{{ $value['phone'] }}<br>
                                            {!! $value['status_desc'] !!}
                                        </td>
                                        <td>
                                            <a href="{{ $value['edit_url'] }}" style="display: block;">编辑信息</a>
                                            <a href="{{ $value['auth_url'] }}" style="display: block;">编辑权限</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
@endsection