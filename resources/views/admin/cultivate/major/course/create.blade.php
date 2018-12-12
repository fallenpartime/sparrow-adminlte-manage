@extends('admin.layouts.main')
@section('title', '创建专业课程-专业课程管理-培训中心')
@section('other_resource')
    @include('admin.layouts.picture')
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">创建专业课程</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>名称 *</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>编号 *</label>
                            <input type="text" name="no" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>所属专业 *</label>
                            <select name="major_no" class="form-control" style="width: 100%;">
                                @if(!empty($majorList))
                                    @foreach($majorList as $majorItem)
                                        <option value="{{ $majorItem->no }}" @if($major_no === $majorItem->no)selected @endif>{{ $majorItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>课程类型 *</label>
                            <select name="type" class="form-control" style="width: 100%;">
                                @if(!empty($typeList))
                                    @foreach($typeList as $typeKey => $typeItem)
                                        <option value="{{ $typeKey }}">{{ $typeItem }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>课程等级 *</label>
                            <select name="level_no" class="form-control" style="width: 100%;">
                                <option value="">请选择</option>
                                @if(!empty($levelList))
                                    @foreach($levelList as $levelItem)
                                        <option value="{{ $levelItem->no }}">{{ $levelItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>简介</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="请输简介"></textarea>
                        </div>
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