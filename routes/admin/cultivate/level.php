<?php
/**
 * 等级路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/level', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\LevelController@index'
    ])->name('admin.cultivate.level');
    Route::match(['get', 'post'], '/admin/cultivate/level/create', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\LevelController@create'
    ])->name('admin.cultivate.level.create');
    Route::match(['get', 'post'], '/admin/cultivate/level/edit', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\LevelController@edit'
    ])->name('admin.cultivate.level.edit');
});