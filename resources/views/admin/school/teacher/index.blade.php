@extends('admin.layouts.main')
@section('title', '教师列表-教师管理-培训中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">教师列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>教师编号</label>
                                    <input type="text" name="no" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'no') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>教师姓名</label>
                                    <input type="text" name="name" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'name') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>联系方式</label>
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
                                <th width="10%">教师编号</th>
                                <th width="10%">教师名称</th>
                                <th width="10%">性别</th>
                                <th width="15%">联系方式</th>
                                <th width="10%">是否兼职</th>
                                <th width="15%">创建时间</th>
                                <th width="15%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->no }}
                                    </td>
                                    <td>
                                        {{ $value->name }}
                                    </td>
                                    <td>
                                        {{ $value->sex == 1? '男': ($value->sex == 2? '女': '') }}
                                    </td>
                                    <td>
                                        {{ $value->phone }}
                                    </td>
                                    <td>
                                        {{ $value->duty == 1? '是': '否' }}
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
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
    @if($operateList['allow_remove'])
        <script>
            function remove(id) {
                if (confirm('确定提交？')) {
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