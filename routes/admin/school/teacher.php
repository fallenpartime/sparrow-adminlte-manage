<?php
/**
 * 教师路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/teacher', [
        'uses' => '\App\Http\Admin\Controllers\School\TeacherController@index'
    ])->name('admin.cultivate.teacher');
    Route::match(['get', 'post'], '/admin/cultivate/teacher/create', [
        'uses' => '\App\Http\Admin\Controllers\School\TeacherController@create'
    ])->name('admin.cultivate.teacher.create');
    Route::match(['get', 'post'], '/admin/cultivate/teacher/edit', [
        'uses' => '\App\Http\Admin\Controllers\School\TeacherController@edit'
    ])->name('admin.cultivate.teacher.edit');
    Route::match(['get', 'post'], '/admin/cultivate/teacher/remove', [
        'uses' => '\App\Http\Admin\Controllers\School\TeacherController@remove'
    ])->name('admin.cultivate.teacher.remove');
});