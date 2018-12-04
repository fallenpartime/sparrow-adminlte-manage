@extends('admin.layouts.main')
@section('title', '创建角色-角色管理-权限中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">创建角色</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>编号 *</label>
                            <input type="text" name="no" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>角色名称 *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>入口</label>
                            <select class="form-control" name="indexurl" style="width: 100%;">
                                <option value="">请选择</option>
                                @if(!empty($indexUrls))
                                    @foreach($indexUrls as $indexTag => $indexUrl)
                                        <option value="{{ $indexTag }}">{{ $indexUrl['title'] }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>所属分组</label>
                            <div class="checkbox">
                                @if(!empty($groups))
                                    @foreach($groups as $group)
                                        <?php
                                        $groupModel = $group['model'];
                                        $access = $group['access'];
                                        ?>
                                        <label><input type="checkbox" name="{{ $groupModel->tip }}" value="{{ $groupModel->group_no }}"> {{ $groupModel->name }}分组&nbsp;</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" onclick="groupSave();">提交</button>
            </div>
            @include('admin.system.role.check_list', ['authorities' => $authorities])
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