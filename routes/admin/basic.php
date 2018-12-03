<?php
/**
 * 基础路由
 */
Route::middleware(['web'])->group(function () {
    Route::get('/admin/warn', [
        'uses' => '\App\Http\Admin\Controllers\BasicController@warn'
    ])->name('admin.warn');
    Route::match(['get', 'post'], '/admin/login', [
        'uses' => '\App\Http\Admin\Controllers\BasicController@login'
    ])->name('admin.login');
    Route::get('/admin/check', [
        'uses' => '\App\Http\Admin\Controllers\BasicController@check'
    ])->name('admin.check');
});