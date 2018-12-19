@extends('admin.layouts.main')
@section('title', '订单列表-订单管理-交易中心')
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
                    <h3 class="box-title">订单列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>用户ID</label>
                                    <input type="text" name="user_id" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'nick_name')?: '' }}">
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
                                    <label>订单类型</label>
                                    <select name="type" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($orderTypeList))
                                            @foreach($orderTypeList as $orderType => $item)
                                                <option value="{{ $orderType }}" @if(array_get($urlParams, 'type') == $orderType)selected="selected"@endif>{{ $item['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>支付类型</label>
                                    <select name="pay_type" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($payTypeList))
                                            @foreach($payTypeList as $payType => $item)
                                                <option value="{{ $payType }}" @if(array_get($urlParams, 'pay_type') == $payType)selected="selected"@endif>{{ $item['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>支付状态</label>
                                    <select name="pay_status" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($payStatusList))
                                            @foreach($payStatusList as $payStatus => $item)
                                                <option value="{{ $payStatus }}" @if(array_get($urlParams, 'pay_status') == $payStatus)selected="selected"@endif>{{ $item['name'] }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>订单号</label>
                                    <input type="text" name="order_no" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'order_no') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>支付单号</label>
                                    <input type="text" name="out_trade_no" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'out_trade_no') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>订单金额</label>
                                    <input type="text" name="order_money" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'order_money')?: '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>应付金额</label>
                                    <input type="text" name="money_payed" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'money_payed')?: '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>实付金额</label>
                                    <input type="text" name="real_money" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'real_money')?: '' }}">
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
                                <th width="10%">订单号</th>
                                <th width="15%">用户信息</th>
                                <th width="10%">支付单号</th>
                                <th width="10%">订单类型</th>
                                <th width="10%">支付类型</th>
                                <th width="10%">金额</th>
                                <th width="10%">状态</th>
                                <th width="13%">创建时间</th>
                                <th width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->order_no }}
                                    </td>
                                    <td>
                                        ID:{{ $value->user_id }}<br>
                                        昵称:{{ $value->nick_name }}<br>
                                        电话:{{ $value->phone }}
                                    </td>
                                    <td>
                                        {{ $value->out_trade_no }}
                                    </td>
                                    <td>
                                        {{ $value->status_list['order_type'] }}
                                    </td>
                                    <td>
                                        {{ $value->status_list['pay_type'] }}
                                    </td>
                                    <td>
                                        订单金额:{{ $value->order_money }}<br>
                                        应付金额:{{ $value->real_money }}<br>
                                        @if(!empty($value->money_payed))
                                        实付金额:{{ $value->money_payed }}<br>
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
    @if($operateList['allow_apply'])
        <script>
            function checkUserApply(id) {
                location.href='{{ $operateUrl['apply_url'] }}?user_id='+id;
            }
        </script>
    @endif
@endsection