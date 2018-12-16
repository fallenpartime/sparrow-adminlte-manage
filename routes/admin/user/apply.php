<?php
/**
 * 用户申请路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/user/apply', [
        'uses' => '\App\Http\Admin\Controllers\User\ApplyController@index'
    ])->name('admin.user.apply');
});