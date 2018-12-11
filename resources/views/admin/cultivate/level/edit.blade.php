@extends('admin.layouts.main')
@section('title', '编辑培训等级-培训等级管理-培训中心')
@section('other_resource')
    @include('admin.layouts.picture')
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">编辑培训等级</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: '' }}">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="float: left;">图标</label>
                            <div id="list-container" style="overflow: hidden; padding-top: 20px; width: 100px; float: left;">
                                <div id="list-up">
                                    <div id="utbtn-ipt"></div>
                                </div>
                            </div>
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
        var uploadhandle = new ImgUploader({
            handler  : 'list-up',
            target   : 'utbtn-ipt',
            container: 'list-container',
            url      : uploadUrl,
            imgNum   : 1,
            key      : 'list_pic'
        })
    </script>
    <script>
        @if(!empty($record) && !empty($record->image))
        initPictureList(uploadhandle, 'list-up', 'list_pic', '{{ $record->image }}', '{{ $record->image }}', 1);
        @endif
    </script>
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