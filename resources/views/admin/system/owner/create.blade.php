@extends('admin.layouts.main')
@section('title', '创建管理员-管理员管理-权限中心')
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">创建管理员</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>用户名 *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>密码</label>
                            <input type="text" name="pwd" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>电话 *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>角色</label>
                            <select class="form-control" name="roleid" style="width: 100%;">
                                <option value="0">请选择</option>
                                @if(!empty($roles))
                                    @foreach($roles as $role)
                                        <option value="{{ $role->role_no }}">{{ $role->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>是否激活</label>
                            <select class="form-control" name="is_admin" style="width: 100%;">
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
                        </div>
                        @if($admin_info['is_super'])
                        <div class="form-group">
                            <label>是否超级管理员</label>
                            <select class="form-control" name="is_super" style="width: 100%;">
                                <option value="0">否</option>
                                <option value="1">是</option>
                            </select>
                        </div>
                        @endif
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