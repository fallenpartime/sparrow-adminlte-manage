@extends('admin.layouts.main')
@section('title', '编辑教师-教师管理-培训中心')
@section('other_resource')
    @include('admin.plugin.datepicker')
    @include('admin.layouts.picture')
    @include('admin.layouts.ue')
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">编辑教师</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <input type="hidden" name="id" value="{{ !empty($record)? $record->id: '' }}">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>教师名称 *</label>
                            <input type="text" name="name" class="form-control" value="{{ $record->name }}" required>
                        </div>
                        <div class="form-group">
                            <label>电话 *</label>
                            <input type="text" name="phone" class="form-control" value="{{ $record->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label>地址 *</label>
                            <input type="text" name="address" class="form-control" value="{{ $record->address }}" required>
                        </div>
                        <div class="form-group">
                            <label>性别 *</label>&nbsp;&nbsp;&nbsp;
                            <div class="radio" style="display: inline;">
                                <label>
                                    <input type="radio" name="sex" value="1"@if($record->sex == 1) checked @endif> 男
                                </label>&nbsp;&nbsp;
                                <label>
                                    <input type="radio" name="sex" value="2"@if($record->sex == 2) checked @endif> 女
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>出生日期</label>
                            <input type="text" id="birthday" name="birthday" class="form-control"  value="{{ $record->birthday }}" style="width: 45%;">
                        </div>
                        <div class="form-group">
                            <label>教师简介</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="请输入教师简介">{{ $record->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>教师编号 *</label>
                            <input type="text" name="no" class="form-control" value="{{ $record->no }}" required>
                        </div>
                        <div class="form-group">
                            <label>职称</label>
                            <select class="form-control" name="positional" style="width: 100%;">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>学历</label>
                            <select class="form-control" name="diploma" style="width: 100%;">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>学位</label>
                            <select class="form-control" name="degree" style="width: 100%;">
                                <option value="0">请选择</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>是否兼职</label>&nbsp;&nbsp;&nbsp;
                            <div class="radio" style="display: inline;">
                                <label>
                                    <input type="radio" name="duty" value="1"@if($record->duty == 1) checked @endif> 是
                                </label>&nbsp;&nbsp;
                                <label>
                                    <input type="radio" name="duty" value="0"@if($record->duty == 0) checked @endif> 否
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="float: left;">头像</label>
                            <div id="list-container" style="overflow: hidden; padding-top: 20px; width: 100px; float: left;">
                                <div id="list-up">
                                    <div id="utbtn-ipt"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>内容</label>
                            <textarea id="content" name="content" rows="3" placeholder="请输入内容">{{ $record->content }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right" onclick="groupSave();">提交</button>
            </div>
        </form>
    </div>
    <script type="text/javascript">
        initSimpleDaterangepicker('birthday', 'YYYY-MM-DD');
    </script>
    <script>
        var uploadhandle = new ImgUploader({
            handler  : 'list-up',
            target   : 'utbtn-ipt',
            container: 'list-container',
            url      : uploadUrl,
            imgNum   : 1,
            key      : 'list_pic'
        })
        @if(!empty($record) && !empty($record->face))
        initPictureList(uploadhandle, 'list-up', 'list_pic', '{{ $record->face }}', '{{ $record->face }}', 1);
        @endif
    </script>
    <script>
        initUEditor('content');
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