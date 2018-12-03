@extends('admin.layouts.main')
@section('title', '权限列表-权限管理-编辑权限')
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">编辑权限</h3>
        </div>
        <form id="authorForm" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: 0 }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>所属一级权限</label>
                            <select id="first_menu" name="first_menu" class="form-control" style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>所属二级权限</label>
                            <select id="second_menu" name="second_menu" class="form-control" style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group">
                            <label>权限类型 *</label>
                            <select class="form-control" name="type" style="width: 100%;" required>
                                <option value="0">请选择</option>
                                <option value="1" @if(!empty($record) && $record->type==1)selected="selected"@endif>一级权限</option>
                                <option value="2" @if(!empty($record) && $record->type==2)selected="selected"@endif>二级权限</option>
                                <option value="3" @if(!empty($record) && $record->type==3)selected="selected"@endif>三级权限</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>权限名称 *</label>
                            <input type="text" name="ts_name" class="form-control" value="{{ !empty($record)? $record->name: '' }}" required>
                        </div>
                        <div class="form-group">
                            <label>权限标示 *</label>
                            <input type="text" name="ts_action" class="form-control" value="{{ !empty($record)? $record->ts_action: '' }}" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" onclick="authorizationSave();">提交</button>
            </div>
        </form>
    </div>
    <script>
        var auth_arr = @json($relate_menu);
        function initFirstMenu() {
            var pDom = $('#first_menu');
            pDom.empty();
            pDom.append('<option value=""></option>');
            for(var i in auth_arr){
                pDom.append('<option value="'+auth_arr[i]['menu'].id+'">'+auth_arr[i]['menu'].name+'</option>');
            }
        }
        $('#first_menu').change(function () {
            var pDom = $('#second_menu');
            var parent = $('#first_menu').val();
            pDom.empty();
            if (parent != '') {
                pDom.append('<option value=""></option>');
                for(var j in auth_arr[parent]['list']){
                    pDom.append('<option value="'+auth_arr[parent]['list'][j]['menu'].id+'">'+auth_arr[parent]['list'][j]['menu'].name+'</option>');
                }
            }
        })
        initFirstMenu();
        <?php if(!empty($first_menu)): ?>
        $('#first_menu').val('<?= $first_menu ?>');
        $('#first_menu').trigger('change');
        <?php endif; ?>
        <?php if(!empty($second_menu)): ?>
        $('#second_menu').val('<?= $second_menu ?>');
        $('#second_menu').trigger('change');
        <?php endif; ?>
        function authorizationSave() {
            if (confirm('确定提交？')) {
                $.post(
                    '<?= $actionUrl ?>',
                    $('#authorForm').serialize(),
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