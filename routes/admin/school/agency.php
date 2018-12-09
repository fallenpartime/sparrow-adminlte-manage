<?php
/**
 * 机构路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/agency', [
        'uses' => '\App\Http\Admin\Controllers\School\AgencyController@index'
    ])->name('admin.cultivate.agency');
    Route::match(['get', 'post'], '/admin/cultivate/agency/create', [
        'uses' => '\App\Http\Admin\Controllers\School\AgencyController@create'
    ])->name('admin.cultivate.agency.create');
    Route::match(['get', 'post'], '/admin/cultivate/agency/edit', [
        'uses' => '\App\Http\Admin\Controllers\School\AgencyController@edit'
    ])->name('admin.cultivate.agency.edit');
    Route::match(['get', 'post'], '/admin/cultivate/agency/remove', [
        'uses' => '\App\Http\Admin\Controllers\School\AgencyController@remove'
    ])->name('admin.cultivate.agency.remove');
});