@extends('admin.layouts.main')
@section('title', '创建开班报价-开班报价管理-培训中心')
@section('other_resource')
@endsection
@section('wrapper_content')
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">创建开班报价</h3>
        </div>
        <form id="actionForm" action="#" method="post" onsubmit="return false">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>所属开班 *</label>
                            <select name="course_no" class="form-control" style="width: 100%;">
                                @if(!empty($courseList))
                                    @foreach($courseList as $courseItem)
                                        <option value="{{ $courseItem->no }}" @if($course_no === $courseItem->no)selected @endif>{{ $courseItem->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>报价类型 *</label>
                            <select name="type" class="form-control" style="width: 100%;">
                                <option value="">请选择</option>
                                @if(!empty($typeList))
                                    @foreach($typeList as $typeIndex => $typeItem)
                                        <option value="{{ $typeIndex }}">{{ $typeItem }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>培训费用</label>
                            <input type="text" name="train" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>鉴定费用</label>
                            <input type="text" name="identify" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>总价 *</label>
                            <input type="text" name="money" class="form-control" placeholder="未打折总价" required>
                        </div>
                        <div class="form-group">
                            <label>折扣</label>
                            <input type="text" name="discount" class="form-control" placeholder="1-10折" required>
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