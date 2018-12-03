<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/assets/admin/css/app.css">
    <script src="/assets/admin/js/app.js"></script>
    @yield('other_resource')
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</head>
<!-- ADD THE CLASS sidebar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini">
<div class="wrapper">
    @include('admin.layouts.header', ['admin_info'=>$admin_info])
    @include('admin.layouts.sidebar', ['admin_info'=>$admin_info, 'ts_list'=>$ts_list, 'menu'=>$menu])
    <div class="content-wrapper">
        <section class="content-header">
            <h1><small></small></h1>
            <ol class="breadcrumb">
                @if(!empty($menu))
                    @foreach($menu as $headerMenuItem)
                        @if($headerMenuItem['active'])<li class="active">{{ $headerMenuItem['title'] }}</li>@else<li><a href="@if($headerMenuItem['url']){{ $headerMenuItem['url'] }}@else#@endif">{{ $headerMenuItem['title'] }}</a></li>@endif
                    @endforeach
                @endif
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            @yield('wrapper_content')
        </section>
        <!-- /.content -->
    </div>
    <footer class="main-footer">
    </footer>
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script src="/assets/admin/js/main.js"></script>
</body>
</html>
