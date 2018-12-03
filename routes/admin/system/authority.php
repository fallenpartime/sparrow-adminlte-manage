<?php
/**
 * 权限路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/system/authority', [
        'uses' => '\App\Http\Admin\Controllers\System\AuthorityController@index'
    ])->name('admin.system.authority');
    Route::match(['get', 'post'], '/admin/system/authority/create', [
        'uses' => '\App\Http\Admin\Controllers\System\AuthorityController@create'
    ])->name('admin.system.authority.create');
    Route::match(['get', 'post'], '/admin/system/authority/edit', [
        'uses' => '\App\Http\Admin\Controllers\System\AuthorityController@edit'
    ])->name('admin.system.authority.edit');
});