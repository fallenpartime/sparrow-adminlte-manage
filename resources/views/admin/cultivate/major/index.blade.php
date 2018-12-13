@extends('admin.layouts.main')
@section('title', '培训专业列表-培训专业管理-培训中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">培训专业列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-2">
                                    <label>编号</label>
                                    <input type="text" name="no" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'no') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>名称</label>
                                    <input type="text" name="name" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'name') }}">
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
                                <th width="20%">编号</th>
                                <th width="20%">名称</th>
                                <th width="20%">图片</th>
                                <th width="20%">创建时间</th>
                                <th width="20%">操作</th>
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
                                        @if(!empty($value->image))
                                            <img src="{{ $value->image }}" style="width: 60px; height: 60px;">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_operate_edit'])
                                            <a href="{{ $value->edit_url }}" style="display: block;">编辑</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_create_course'])
                                            <a href="javascript:;" style="display: block;" onclick="createCourse('{{ $value->no }}')">创建课程</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_create_kcourse'])
                                            <a href="javascript:;" style="display: block;" onclick="createKCourse('{{ $value->no }}')">创建开班</a>
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
    @if($operateList['allow_create_course'])
        <script>
            function createCourse(no) {
                if (confirm('确定创建课程？')) {
                    location.href='{{ $operateUrl['create_course_url'] }}?major_no='+no;
                }
            }
        </script>
    @endif
    @if($operateList['allow_create_kcourse'])
        <script>
            function createKCourse(no) {
                if (confirm('确定创建开班？')) {
                    location.href='{{ $operateUrl['create_kcourse_url'] }}?major_no='+no;
                }
            }
        </script>
    @endif
@endsection