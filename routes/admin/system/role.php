<?php
/**
 * 角色路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/system/role', [
        'uses' => '\App\Http\Admin\Controllers\System\RoleController@index'
    ])->name('admin.system.role');
    Route::match(['get', 'post'], '/admin/system/role/create', [
        'uses' => '\App\Http\Admin\Controllers\System\RoleController@create'
    ])->name('admin.system.role.create');
    Route::match(['get', 'post'], '/admin/system/role/{id}', [
        'uses' => '\App\Http\Admin\Controllers\System\RoleController@edit'
    ])->name('admin.system.role.edit');
});