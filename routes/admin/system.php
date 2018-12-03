<?php
/**
 * 系统路由
 */
Route::middleware(['web', 'admin.login.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/index', [
        'uses' => '\App\Http\Admin\Controllers\SystemController@index'
    ])->name('admin.index');
});
// 权限路由
require __DIR__.'/system/authority.php';
// 分组路由
require __DIR__.'/system/group.php';
// 角色路由
require __DIR__.'/system/role.php';
// 管理员路由
require __DIR__.'/system/owner.php';
// 分组路由
require __DIR__.'/system/log.php';