<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th><input type="checkbox" class="first_all_check">&nbsp;&nbsp;一级权限</th>
                        <th><input type="checkbox" class="second_all_check">&nbsp;&nbsp;二级权限</th>
                        <th><input type="checkbox" class="third_all_check">&nbsp;&nbsp;三级权限</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($authorities as $topItem)
                        <?php
                        $topModel = $topItem['menu'];
                        $secondLength = $topItem['length'];
                        $secondList = $topItem['list'];
                        $countSecond = 0;
                        ?>
                        @if(!empty($secondList))
                            @foreach($secondList as $secondItem)
                                <?php
                                $secondModel = $secondItem['menu'];
                                $operateLength = $secondItem['length'];
                                $operateList = $secondItem['list'];
                                $operateSecond = 0;
                                ?>
                                @if(!empty($operateList))
                                    @foreach($operateList as $operateItem)
                                        <?php $operateModel = $operateItem['menu']; ?>
                                        <tr>
                                            @if($countSecond == 0 && $operateSecond == 0)
                                                <td rowspan="{{ $secondLength }}"><input type="checkbox" class="first_level" name="auth_checked[]" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif>&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                            @endif
                                            @if($operateSecond == 0)
                                                <td rowspan="{{ $operateLength }}"><input type="checkbox" class="second_level" name="auth_checked[]" value="{{ $secondModel->ts_action }}" @if($secondModel->is_checked)checked="checked"@endif>&nbsp;{{ $secondModel->name }}({{ $secondModel->ts_action }})</td>
                                            @endif
                                            <td><input type="checkbox" class="third_level" name="auth_checked[]" value="{{ $operateModel->ts_action }}" @if($operateModel->is_checked)checked="checked"@endif>&nbsp;{{ $operateModel->name }}({{ $operateModel->ts_action }})</td>
                                            <?php $operateSecond++; ?>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        @if($countSecond == 0 && $operateSecond == 0)
                                            <td rowspan="{{ $secondLength }}"><input type="checkbox" class="first_level" name="auth_checked[]" value="{{ $topModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif>&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                        @endif
                                        <td rowspan="{{ $operateLength }}"><input type="checkbox" class="second_level" name="auth_checked[]" value="{{ $secondModel->ts_action }}" @if($secondModel->is_checked)checked="checked"@endif>&nbsp;{{ $secondModel->name }}({{ $secondModel->ts_action }})</td>
                                        <td></td>
                                    </tr>
                                @endif
                                <?php $countSecond++; ?>
                            @endforeach
                        @else
                            <tr>
                                <td><input type="checkbox" class="third_level" name="auth_checked[]" value="{{ $operateModel->ts_action }}" @if($topModel->is_checked)checked="checked"@endif>&nbsp;{{ $topModel->name }}({{ $topModel->ts_action }})</td>
                                <td rowspan="1"></td>
                                <td rowspan="1"></td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
<script>
    $(".first_all_check").click(function () {
        var checkedValue = $(this).prop('checked')
        if (checkedValue) {
            $(".first_level").prop('checked', true)
        } else {
            $(".first_level").prop('checked', false)
        }
    })
    $(".second_all_check").click(function () {
        var checkedValue = $(this).prop('checked')
        if (checkedValue) {
            $(".second_level").prop('checked', true)
        } else {
            $(".second_level").prop('checked', false)
        }
    })
    $(".third_all_check").click(function () {
        var checkedValue = $(this).prop('checked')
        if (checkedValue) {
            $(".third_level").prop('checked', true)
        } else {
            $(".third_level").prop('checked', false)
        }
    })
</script>