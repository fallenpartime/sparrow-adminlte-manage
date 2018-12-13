@extends('admin.layouts.main')
@section('title', '编辑开班教师-开班教师管理-培训中心')
@section('other_resource')
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">编辑开班教师</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="id" value="{{ $record->id }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>所属开班 *</label>
                            <select name="course_no" class="form-control" style="width: 100%;">
                                @if(!empty($courseList))
                                    @foreach($courseList as $courseItem)
                                        <option value="{{ $courseItem->no }}" @if($record->course_no === $courseItem->no)selected @endif>{{ $courseItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>授课教师 *</label>
                            <select name="teacher_no" class="form-control" style="width: 100%;">
                                <option value="">请选择</option>
                                @if(!empty($teacherList))
                                    @foreach($teacherList as $teacherItem)
                                        <option value="{{ $teacherItem->no }}" @if($record->teacher_no === $teacherItem->no)selected @endif>{{ $teacherItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" onclick="groupSave();">提交</button>
            </div>
        </form>
    </div>
    <script>
        function groupSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '<?= $actionUrl ?>',
                    $('#actionForm').serialize(),
                    function (result) {
                        result = JSON.parse(result)
                        if (result.code == 200) {
                            var redirectUrl = '{{ $redirectUrl }}';
                            location.href=redirectUrl;
                        } else {
                            alert(result.msg)
                        }
                    }
                )
            }
        }
    </script>
@endsection