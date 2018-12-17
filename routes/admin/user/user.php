<?php
/**
 * 用户路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/user', [
        'uses' => '\App\Http\Admin\Controllers\UserController@index'
    ])->name('admin.user');
});