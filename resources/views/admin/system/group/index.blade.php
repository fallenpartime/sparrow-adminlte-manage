@extends('admin.layouts.main')
@section('title', '分组列表-分组管理-权限中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">分组列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="19%">编号</th>
                                <th width="19%">分组名</th>
                                <th width="19%">分组Tip</th>
                                <th width="19%">创建时间</th>
                                <th width="19%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($list))
                                @foreach($list as $key => $value)
                                    <tr>
                                        <td>
                                            {{ $value->group_no }}
                                        </td>
                                        <td>
                                            {{ $value->name }}
                                        </td>
                                        <td>
                                            {{ $value->tip }}
                                        </td>
                                        <td>
                                            {{ $value->created_at }}
                                        </td>
                                        <td>
                                            <a href="{{ route(\Admin\Config\RouteConfig::ROUTE_GROUP_EDIT, ['id' => $value->id]) }}" style="display: block;">编辑</a>
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