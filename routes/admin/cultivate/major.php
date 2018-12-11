<?php
/**
 * 专业路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/major', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorController@index'
    ])->name('admin.cultivate.major');
    Route::match(['get', 'post'], '/admin/cultivate/major/create', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorController@create'
    ])->name('admin.cultivate.major.create');
    Route::match(['get', 'post'], '/admin/cultivate/major/edit', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorController@edit'
    ])->name('admin.cultivate.major.edit');
    Route::match(['get', 'post'], '/admin/cultivate/major/remove', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorController@remove'
    ])->name('admin.cultivate.major.remove');
});
/**
 * 专业课程路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/major/course', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorCourseController@index'
    ])->name('admin.cultivate.major.course');
    Route::match(['get', 'post'], '/admin/cultivate/major/course/create', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorCourseController@create'
    ])->name('admin.cultivate.major.course.create');
    Route::match(['get', 'post'], '/admin/cultivate/major/course/edit', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorCourseController@edit'
    ])->name('admin.cultivate.major.course.edit');
    Route::match(['get', 'post'], '/admin/cultivate/major/course/remove', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\MajorCourseController@remove'
    ])->name('admin.cultivate.major.course.remove');
});