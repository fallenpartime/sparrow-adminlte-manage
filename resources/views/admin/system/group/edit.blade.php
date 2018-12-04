@extends('admin.layouts.main')
@section('title', '编辑分组-分组管理-权限中心')
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">编辑分组</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>编号 *</label>
                            <input type="text" name="group_no" class="form-control" value="{{ $record->group_no }}" required>
                        </div>
                        <div class="form-group">
                            <label>分组名称 *</label>
                            <input type="text" name="name" class="form-control" value="{{ $record->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>分组Tip *</label>
                            <input type="text" name="tip" class="form-control" value="{{ $record->tip }}" required>
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