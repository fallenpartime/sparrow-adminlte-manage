@extends('admin.layouts.main')
@section('title', '文章列表-文章管理-推广中心')
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
                    <h3 class="box-title">文章列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>标题</label>
                                    <input type="text" name="title" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'title') }}">
                                </div>
                                <div class="form-group col-md-1">
                                    <label>显示状态</label>
                                    <select name="is_show" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        <option value="1" @if(array_get($urlParams, 'is_show') == 1)selected="selected"@endif>显示</option>
                                        <option value="2" @if(array_get($urlParams, 'is_show') == 2)selected="selected"@endif>隐藏</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label style="display: block;">创建时间</label>
                                    <input type="text" id="from_time" name="from_time" class="form-control" value="{{ array_get($urlParams, 'from_time') }}" style="width: 45%;">-
                                    <input type="text" id="end_time" name="end_time" class="form-control" value="{{ array_get($urlParams, 'end_time') }}" style="width: 45%;">
                                </div>
                                <div class="form-group col-md-4">
                                    <label style="display: block;">发布时间</label>
                                    <input type="text" id="from_publish_time" name="from_publish_time" class="form-control" value="{{ array_get($urlParams, 'from_publish_time') }}" style="width: 45%;">-
                                    <input type="text" id="end_publish_time" name="end_publish_time" class="form-control" value="{{ array_get($urlParams, 'end_publish_time') }}" style="width: 45%;">
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
                                <th width="15%">标题</th>
                                <th width="10%">作者</th>
                                <th width="10%">图片</th>
                                <th width="10%">显示状态</th>
                                <th width="8%">阅读数</th>
                                <th width="13%">创建时间</th>
                                <th width="13%">发布时间</th>
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
                                        {{ $value->title }}
                                    </td>
                                    <td>
                                        {{ $value->author }}
                                    </td>
                                    <td>
                                        @if(!empty($value->list_pic))
                                            <a href="{{ $value->list_pic }}" target="_blank"><img src="{{ $value->list_pic }}" style="width: 60px; height: 60px;"></a>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->status_list['show_status'] }}
                                    </td>
                                    <td>
                                        {{ $value->read_count }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        {{ $value->published_at }}
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_operate_edit'])
                                            <a href="{{ $value->edit_url }}" style="display: block;">编辑</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_remove'])
                                            <a href="javascript:;" style="display: block;" onclick="remove({{ $value->id }})">作废</a>
                                        @endif
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
        initDaterangepicker('from_publish_time', 'YYYY-MM-DD HH:mm:ss');
        initDaterangepicker('end_publish_time', 'YYYY-MM-DD HH:mm:ss');
    </script>
    @if($operateList['allow_remove'])
        <script>
            function remove(id) {
                if (confirm('确定作废文章？')) {
                    $.post(
                        '{{ $operateUrl['remove_url'] }}',
                        {id: id},
                        function (result) {
                            result = JSON.parse(result)
                            if (result.code == 200) {
                                location.href = '{{ $redirectUrl }}';
                            } else {
                                alert(result.msg)
                            }
                        }
                    )
                }
            }
        </script>
    @endif
@endsection