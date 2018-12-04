<?php
/**
 * 管理员路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/system/owner', [
        'uses' => '\App\Http\Admin\Controllers\System\OwnerController@index'
    ])->name('admin.system.owner');
    Route::match(['get', 'post'], '/admin/system/owner/create', [
        'uses' => '\App\Http\Admin\Controllers\System\OwnerController@create'
    ])->name('admin.system.owner.create');
    Route::match(['get', 'post'], '/admin/system/owner/edit', [
        'uses' => '\App\Http\Admin\Controllers\System\OwnerController@edit'
    ])->name('admin.system.owner.edit');
    Route::match(['get', 'post'], '/admin/system/owner/authority', [
        'uses' => '\App\Http\Admin\Controllers\System\OwnerController@authority'
    ])->name('admin.system.owner.authority');
});