@extends('admin.layouts.main')
@section('title', '开班教师列表-开班教师管理-培训中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">开班教师列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-1">
                                    <label>开班年份</label>
                                    <input type="text" name="year" class="form-control" style="width: 100%;" value="{{ !empty($urlParams['year'])? $urlParams['year']: '' }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>开班编号</label>
                                    <select name="course_no" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($courseList))
                                            @foreach($courseList as $courseItem)
                                                <option value="{{ $courseItem->no }}" @if(array_get($urlParams, 'course_no') === $courseItem->no)selected="selected"@endif>{{ $courseItem->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>等级</label>
                                    <select name="level_no" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($levelList))
                                            @foreach($levelList as $levelItem)
                                                <option value="{{ $levelItem->no }}" @if(array_get($urlParams, 'level_no') === $levelItem->no)selected="selected"@endif>{{ $levelItem->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>专业</label>
                                    <select name="major_no" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($majorList))
                                            @foreach($majorList as $majorItem)
                                                <option value="{{ $majorItem->no }}" @if(array_get($urlParams, 'major_no') == $majorItem->no)selected="selected"@endif>{{ $majorItem->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>教师</label>
                                    <select name="teacher_no" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($teacherList))
                                            @foreach($teacherList as $teacherItem)
                                                <option value="{{ $teacherItem->no }}" @if(array_get($urlParams, 'teacher_no') == $teacherItem->no)selected="selected"@endif>{{ $teacherItem->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
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
                                <th width="10%">年份</th>
                                <th width="10%">等级</th>
                                <th width="15%">专业</th>
                                <th width="15%">开班</th>
                                <th width="15%">教师</th>
                                <th width="15%">创建时间</th>
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
                                        @if(isset($value->course))
                                            {{ $value->course->year }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value->course->level))
                                            No:{{ $value->course->level->no }}<br>
                                            {{ $value->course->level->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value->course->major))
                                            No:{{ $value->course->major->no }}<br>
                                            {{ $value->course->major->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value->course))
                                            No:{{ $value->course->no }}<br>
                                            {{ $value->course->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value->teacher))
                                            No:{{ $value->teacher->no }}<br>
                                            {{ $value->teacher->name }}
                                        @endif
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
                if (confirm('确定作废开班教师记录？')) {
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