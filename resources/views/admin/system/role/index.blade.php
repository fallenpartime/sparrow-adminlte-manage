@extends('admin.layouts.main')
@section('title', '角色列表-角色管理-权限中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">角色列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="10%">编号</th>
                                <th width="15%">角色名</th>
                                <th width="35%">权限列表</th>
                                <th width="15%">分组情况</th>
                                <th width="15%">创建时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($list))
                                @foreach($list as $key => $value)
                                    <tr>
                                        <td>
                                            {{ $value['no'] }}
                                        </td>
                                        <td>
                                            {{ $value['name'] }}<br>
                                            入口：{{ $value['indexTag'] }}
                                        </td>
                                        <td style="word-break:break-all; text-align: left;">
                                            {{ $value['actions'] }}
                                        </td>
                                        <td>
                                            {!! $value['group_desc'] !!}
                                        </td>
                                        <td>
                                            {{ $value['created_at'] }}
                                        </td>
                                        <td>
                                            <a href="{{ $value['edit_url'] }}" style="display: block;">编辑</a>
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