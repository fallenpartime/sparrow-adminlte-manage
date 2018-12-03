<?php
/**
 * 日志路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/system/admin/log', [
        'uses' => '\App\Http\Admin\Controllers\System\LogController@systemLog'
    ])->name('admin.system.admin.log');
    Route::match(['get', 'post'], '/admin/system/operate/log', [
        'uses' => '\App\Http\Admin\Controllers\System\LogController@operateLog'
    ])->name('admin.system.operate.log');
});