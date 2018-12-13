@extends('admin.layouts.main')
@section('title', '开班报价列表-开班报价管理-培训中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">开班报价列表</h3>
                </div>
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <form action="" style="padding-bottom: 10px;">
                            <div class="box-tools">
                                <div class="form-group col-md-1">
                                    <label>编号</label>
                                    <input type="text" name="no" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'no') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <label>类别</label>
                                    <select name="type" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        @if(!empty($typeList))
                                            @foreach($typeList as $typeIndex => $typeItem)
                                                <option value="{{ $typeIndex }}" @if(array_get($urlParams, 'type') === $typeIndex)selected="selected"@endif>{{ $typeItem }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>激活状态</label>
                                    <select name="active_status" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        <option value="2" @if(array_get($urlParams, 'active_status') === 2)selected="selected"@endif>已激活</option>
                                        <option value="1" @if(array_get($urlParams, 'active_status') === 1)selected="selected"@endif>未激活</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>使用状态</label>
                                    <select name="used_status" class="form-control" style="width: 100%;">
                                        <option value="">全部</option>
                                        <option value="2" @if(array_get($urlParams, 'used_status') === 2)selected="selected"@endif>已使用</option>
                                        <option value="1" @if(array_get($urlParams, 'used_status') === 1)selected="selected"@endif>未使用</option>
                                    </select>
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
                                <div class="form-group col-md-1">
                                    <label>开班年份</label>
                                    <input type="text" name="year" class="form-control" style="width: 100%;" value="{{ !empty($urlParams['year'])? $urlParams['year']: '' }}">
                                </div>
                                <div class="form-group col-md-1">
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
                                <th width="10%">编号</th>
                                <th width="10%">类型</th>
                                <th width="10%">等级</th>
                                <th width="10%">专业</th>
                                <th width="10%">开班</th>
                                <th width="10%">费用</th>
                                <th width="10%">状态</th>
                                <th width="15%">创建时间</th>
                                <th width="10%">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $value)
                                <tr>
                                    <td>
                                        {{ $value->no }}
                                    </td>
                                    <td>
                                        {{ $value->status_list['type_desc'] }}
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
                                        培训:{{ $value->train }}<br>
                                        鉴定:{{ $value->identify }}<br>
                                        折扣:{{ $value->discount }}<br>
                                        总计:{{ $value->money }}<br>
                                        实际支付:{{ $value->real_money }}<br>
                                    </td>
                                    <td>
                                        {{ $value->status_list['active_desc'] }}<br>
                                        {{ $value->status_list['used_desc'] }}<br>
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_active'])
                                            <a href="javascript:;" style="display: block;" onclick="activePrice({{ $value->id }})">激活</a>
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
    @if($operateList['allow_active'])
        <script>
            function activePrice(id) {
                if (confirm('确定激活报价？')) {
                    $.post(
                        '{{ $operateUrl['active_url'] }}',
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