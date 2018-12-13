@extends('admin.layouts.main')
@section('title', '开班列表-开班管理-培训中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">开班列表</h3>
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
                                <div class="form-group col-md-2">
                                    <label>开班年份</label>
                                    <input type="text" name="year" class="form-control" style="width: 100%;" value="{{ array_get($urlParams, 'year') }}">
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
                                <th width="10%">名称</th>
                                <th width="5%">年份</th>
                                <th width="10%">等级</th>
                                <th width="10%">专业</th>
                                <th width="10%">开班期数</th>
                                <th width="10%">当前报价</th>
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
                                        {{ $value->name }}
                                    </td>
                                    <td>
                                        {{ $value->year }}
                                    </td>
                                    <td>
                                        @if(isset($value->level))
                                            No:{{ $value->level->no }}<br>
                                            {{ $value->level->name }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($value->major))
                                            No:{{ $value->major->no }}<br>
                                            {{ $value->major->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->num }}
                                    </td>
                                    <td>
                                        @if(isset($value->currentPrice))
                                            定价:{{ $value->currentPrice->money }}<br>
                                            实际:{{ $value->currentPrice->real_money }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $value->created_at }}
                                    </td>
                                    <td>
                                        @if($value->operate_list['allow_operate_edit'])
                                            <a href="{{ $value->edit_url }}" style="display: block;">编辑</a>
                                        @endif
                                        @if($value->operate_list['allow_operate_create_teacher'])
                                            <a href="javascript:;" style="display: block;" onclick="createTeacher('{{ $value->no }}')">创建关联教师</a>
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
                if (confirm('确定作废开班记录？')) {
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
    @if($operateList['allow_create_teacher'])
        <script>
            function createTeacher(no) {
                if (confirm('确定创建关联教师？')) {
                    location.href='{{ $operateUrl['create_teacher_url'] }}?course_no='+no;
                }
            }
        </script>
    @endif
@endsection