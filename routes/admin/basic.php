<?php
Route::middleware(['web'])->group(function () {
    Route::get('/admin/warn', [
        'as' => 'admin.warn',
        'uses' => '\App\Http\Admin\Controllers\BasicController@warn'
    ]);
//    Route::match(['get', 'post'], '/admin/login', [
//        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@login'
//    ])->name('admin.login');
//    Route::get('/admin/check', [
//        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@check'
//    ])->name('admin.check');
//    Route::get('/admin/qrcode', [
//        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@qrcode'
//    ])->name('admin.qrcode');
});