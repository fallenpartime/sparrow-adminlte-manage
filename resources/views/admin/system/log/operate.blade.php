@extends('admin.layouts.main')
@section('title', '业务日志-日志管理-权限中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/css/daterangepicker.css">
    <script src="/assets/admin/js/moment.min.js"></script>
    <script src="/assets/admin/js/daterangepicker.js"></script>
    <script></script>
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">业务日志</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>操作人</label>
                                    <select name="user_id" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($owners))
                                            @foreach($owners as $owner)
                                                <option value="{{ $owner->id }}" @if(array_get($urlParams, 'user_id') == $owner->id)selected="selected"@endif>{{ $owner->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>操作对象ID</label>
                                    <input type="text" name="object_id" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'object_id') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>操作名称</label>
                                    <select name="operate_type" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($typeList))
                                            @foreach($typeList as $operateId => $operateValue)
                                                <option value="{{ $operateId }}" @if(array_get($urlParams, 'operate_type') == $operateId)selected="selected"@endif>{{ $operateValue }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label style="display: block;">操作时间</label>
                                    <input type="text" id="from_time" name="from_time" class="form-control" value="{{ array_get($urlParams, 'from_time') }}" style="width: 45%;">-
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
                                <th width="10%">用户名</th>
                                <th width="10%">操作名称</th>
                                <th width="10%">操作对象ID</th>
                                <th width="30%">操作备注</th>
                                <th width="15%">IP</th>
                                <th width="15%">创建时间</th>
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
                                            ID：{{ $value->user_id }}<br>
                                            姓名：{{ $value->user->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($typeList[$value->operate_type]))
                                            {{ $typeList[$value->operate_type] }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->object_id }}
                                    </td>
                                    <td style="text-align:left;word-break: break-all; word-wrap:break-word;">
                                        {{ $value->memo }}
                                    </td>
                                    <td>
                                        {{ $value->ip }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
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
        $('#from_time').daterangepicker({
            "timePicker": true,
            "timePickerSeconds": true,
            "singleDatePicker": true,
            "timePicker24Hour": true,
            "linkedCalendars": false,
            "autoUpdateInput": false,
            "locale": {
                format: 'YYYY-MM-DD HH:mm:ss',
                applyLabel: "应用",
                cancelLabel: "取消",
                resetLabel: "重置",
            }
        }, function(start, end, label) {
            console.log(this.startDate.format(this.locale.format));
            console.log(this.endDate.format(this.locale.format));
            if(!this.startDate){
                this.element.val('');
            }else{
                this.element.val(this.startDate.format(this.locale.format));
            }
        });
        $('#end_time').daterangepicker({
            "timePicker": true,
            "timePickerSeconds": true,
            "singleDatePicker": true,
            "timePicker24Hour": true,
            "linkedCalendars": false,
            "autoUpdateInput": false,
            "locale": {
                format: 'YYYY-MM-DD HH:mm:ss',
                applyLabel: "应用",
                cancelLabel: "取消",
                resetLabel: "重置",
            }
        }, function(start, end, label) {
            console.log(this.startDate.format(this.locale.format));
            console.log(this.endDate.format(this.locale.format));
            if(!this.startDate){
                this.element.val('');
            }else{
                this.element.val(this.startDate.format(this.locale.format));
            }
        });
    </script>
@endsection