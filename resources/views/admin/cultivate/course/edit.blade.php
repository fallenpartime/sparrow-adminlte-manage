@extends('admin.layouts.main')
@section('title', '编辑开班-开班管理-培训中心')
@section('other_resource')
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">编辑开班</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="id" value="{{ $record->id }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>名称 *</label>
                            <input type="text" name="name" class="form-control" value="{{ $record->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>编号 *</label>
                            <input type="text" name="no" class="form-control" value="{{ $record->no }}" required>
                        </div>
                        <div class="form-group">
                            <label>年份 *</label>
                            <input type="text" name="year" class="form-control" value="{{ $record->year }}" required>
                        </div>
                        <div class="form-group">
                            <label>开班数 *</label>
                            <input type="text" name="num" class="form-control" value="{{ $record->num }}" required>
                        </div>
                        <div class="form-group">
                            <label>所属专业 *</label>
                            <select name="major_no" class="form-control" style="width: 100%;">
                                @if(!empty($majorList))
                                    @foreach($majorList as $majorItem)
                                        <option value="{{ $majorItem->no }}" @if($record->major_no === $majorItem->no)selected @endif>{{ $majorItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>课程等级 *</label>
                            <select name="level_no" class="form-control" style="width: 100%;">
                                <option value="">请选择</option>
                                @if(!empty($levelList))
                                    @foreach($levelList as $levelItem)
                                        <option value="{{ $levelItem->no }}" @if($record->level_no === $levelItem->no)selected @endif>{{ $levelItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>简介</label>
                            <textarea class="form-control" name="description" rows="4" placeholder="请输简介">{{ $record->description }}</textarea>
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