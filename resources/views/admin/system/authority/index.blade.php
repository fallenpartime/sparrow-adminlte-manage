@extends('admin.layouts.main')
@section('title', '权限列表-权限管理-权限中心')
@section('other_resource')
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/admin/css/dataTables.bootstrap.min.css">
@endsection
@section('wrapper_content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">权限列表</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>一级权限</th>
                                <th>二级权限</th>
                                <th>三级权限</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($list as $topItem)
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
                                                    <td rowspan="{{ $secondLength }}"><a href="{{ $topModel->edit_url }}" target="_blank">{{ $topModel->name }}</a>({{ $topModel->ts_action }})</td>
                                                @endif
                                                @if($operateSecond == 0)
                                                    <td rowspan="{{ $operateLength }}"><a href="{{ $secondModel->edit_url }}" target="_blank">{{ $secondModel->name }}</a>({{ $secondModel->ts_action }})</td>
                                                @endif
                                                <td><a href="{{ $operateModel->edit_url }}" target="_blank">{{ $operateModel->name }}</a>({{ $operateModel->ts_action }})</td>
                                                <?php $operateSecond++; ?>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            @if($countSecond == 0 && $operateSecond == 0)
                                                <td rowspan="{{ $secondLength }}"><a href="{{ $topModel->edit_url }}" target="_blank">{{ $topModel->name }}</a>({{ $topModel->ts_action }})</td>
                                            @endif
                                            <td rowspan="{{ $operateLength }}"><a href="{{ $secondModel->edit_url }}" target="_blank">{{ $secondModel->name }}</a>({{ $secondModel->ts_action }})</td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    <?php $countSecond++; ?>
                                @endforeach
                            @else
                                <tr>
                                    <td><a href="{{ $topModel->edit_url }}" target="_blank">{{ $topModel->name }}</a>({{ $topModel->ts_action }})</td>
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
@endsection