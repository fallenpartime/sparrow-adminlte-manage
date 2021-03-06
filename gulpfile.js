var gulp = require('gulp');
var elixir = require('laravel-elixir');

gulp.task('copy', function () {
    // jQuery
    gulp.src("vendor/bower/jquery/dist/jquery.min.js").pipe(gulp.dest("resources/assets/js/"));
    // BootStarp
    gulp.src("vendor/bower/bootstrap/dist/css/bootstrap.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/bootstrap/dist/js/bootstrap.min.js").pipe(gulp.dest("resources/assets/js/"));
    // AdminLTE
    gulp.src("vendor/bower/admin-lte/dist/css/AdminLTE.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/admin-lte/dist/css/skins/skin-blue.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/admin-lte/dist/css/skins/_all-skins.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/admin-lte/dist/js/adminlte.min.js").pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/admin-lte/dist/img/*").pipe(gulp.dest("public/assets/admin/img/"));
    // FontAwesome
    gulp.src("vendor/bower/font-awesome/css/font-awesome.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/font-awesome/fonts/*").pipe(gulp.dest("public/assets/admin/fonts/"));
    // Ion-icons
    gulp.src("vendor/bower/Ionicons/css/ionicons.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/Ionicons/fonts/*").pipe(gulp.dest("public/assets/admin/fonts/"));
    // SlimScroll
    gulp.src("vendor/bower/jquery-slimscroll/jquery.slimscroll.min.js").pipe(gulp.dest("resources/assets/js/"));
    // iCheck
    gulp.src("vendor/bower/admin-lte/plugins/iCheck/icheck.min.js").pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/admin-lte/plugins/iCheck/square/blue.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/admin-lte/plugins/iCheck/square/blue.png").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/admin-lte/plugins/iCheck/square/blue@2x.png").pipe(gulp.dest("resources/assets/css/"));
    // select2
    gulp.src("vendor/bower/select2/dist/js/select2.full.min.js").pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/select2/dist/js/select2.min.js").pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/select2/dist/css/select2.min.css").pipe(gulp.dest("resources/assets/css/"));
    // pace
    gulp.src("vendor/bower/admin-lte/plugins/pace/pace.min.css").pipe(gulp.dest("resources/assets/css/"));
    gulp.src("vendor/bower/admin-lte/plugins/pace/pace.min.js").pipe(gulp.dest("resources/assets/js/"));
    // fastclick
    gulp.src("vendor/bower/fastclick/lib/fastclick.js").pipe(gulp.dest("resources/assets/js/"));
    // data
    gulp.src("vendor/bower/datatables.net-bs/css/dataTables.bootstrap.min.css").pipe(gulp.dest("public/assets/admin/css/"));
    gulp.src("vendor/bower/datatables.net/js/jquery.dataTables.min.js").pipe(gulp.dest("resources/assets/js/"));
    gulp.src("vendor/bower/datatables.net-bs/js/dataTables.bootstrap.min.js").pipe(gulp.dest("resources/assets/js/"));
    // bootstrap-daterangepicker
    gulp.src("vendor/bower/bootstrap-daterangepicker/daterangepicker.css").pipe(gulp.dest("public/assets/admin/css/"));
    gulp.src("vendor/bower/moment/min/moment.min.js").pipe(gulp.dest("public/assets/admin/js/"));
    gulp.src("vendor/bower/bootstrap-daterangepicker/daterangepicker.js").pipe(gulp.dest("public/assets/admin/js/"));
    // demo
    gulp.src("vendor/bower/admin-lte/dist/js/demo.js").pipe(gulp.dest("resources/assets/js/"));
});
// 合并js
elixir(function (mix) {
    mix.scripts([
        'jquery.min.js',
        'bootstrap.min.js',
        'adminlte.min.js',
        'pace.min.js',
        'jquery.slimscroll.min.js',
        'icheck.min.js',
        'select2.full.min.js',
        'select2.min.js',
        'fastclick.js'
    ], 'public/assets/admin/js/app.js')
    .scripts([
        'jquery.dataTables.min.js',
        'dataTables.bootstrap.min.js'
    ], 'public/assets/admin/js/table.js');
});
// 合并css
elixir(function (mix) {
    mix.styles([
        'bootstrap.min.css',
        'pace.min.css',
        'select2.min.css',
        'AdminLTE.min.css',
        '_all-skins.min.css',
        'skin-blue.min.css',
        'font-awesome.min.css',
        'ionicons.min.css',
        'blue.css'
    ], 'public/assets/admin/css/app.css');
});