<?php
/**
 * 分组路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/system/group', [
        'uses' => '\App\Http\Admin\Controllers\System\GroupController@index'
    ])->name('admin.system.group');
    Route::match(['get', 'post'], '/admin/system/group/create', [
        'uses' => '\App\Http\Admin\Controllers\System\GroupController@create'
    ])->name('admin.system.group.create');
    Route::match(['get', 'post'], '/admin/system/group/edit', [
        'uses' => '\App\Http\Admin\Controllers\System\GroupController@edit'
    ])->name('admin.system.group.edit');
});