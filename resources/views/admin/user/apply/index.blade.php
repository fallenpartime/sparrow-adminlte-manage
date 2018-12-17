@extends('admin.layouts.main')
@section('title', '用户申请列表-用户申请管理-用户中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
    @include('admin.plugin.datepicker')
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">用户申请列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>用户ID</label>
                                    <input type="text" name="user_id" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'user_id') ?: '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>昵称</label>
                                    <input type="text" name="nick_name" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'nick_name') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>电话</label>
                                    <input type="text" name="phone" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'phone') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>开班编号</label>
                                    <input type="text" name="course_no" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'course_no') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>申请人姓名</label>
                                    <input type="text" name="apply_name" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'apply_name') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>支付状态</label>
                                    <select name="pay_status" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        <option value="2" @if(array_get($urlParams, 'pay_status') == 2)selected="selected"@endif>已支付</option>
                                        <option value="1" @if(array_get($urlParams, 'pay_status') == 1)selected="selected"@endif>未支付</option>
                                        <option value="3" @if(array_get($urlParams, 'pay_status') == 3)selected="selected"@endif>支付失败</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label style="display: block;">创建时间</label>
                                    <input type="text" id="from_time" name="from_time" class="form-control" value="{{ array_get($urlParams, 'from_time') }}" style="width: 45%;"> -
                                    <input type="text" id="end_time" name="end_time" class="form-control" value="{{ array_get($urlParams, 'end_time') }}" style="width: 45%;">
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
                                <th width="10%">ID</th>
                                <th width="15%">用户</th>
                                <th width="10%">头像</th>
                                <th width="10%">开班信息</th>
                                <th width="10%">支付状态</th>
                                <th width="13%">创建时间</th>
                                <th width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->id }}
                                    </td>
                                    <td>
                                        @if(!empty($value->user))
                                            昵称:{{ $value->user->nick_name }}<br>
                                            电话:{{ $value->user->phone }}<br>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($value->user) && !empty($value->user->face))
                                            <a href="{{ $value->user->face }}" target="_blank"><img src="{{ $value->user->face }}" style="width: 60px; height: 60px;"></a>
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($value->course))
                                            {{ $value->course->no }}<br>
                                            {{ $value->course->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->status_list['pay_status'] }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {!! $pageList !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <script type="text/javascript">
        initDaterangepicker('from_time', 'YYYY-MM-DD HH:mm:ss');
        initDaterangepicker('end_time', 'YYYY-MM-DD HH:mm:ss');
    </script>
@endsection