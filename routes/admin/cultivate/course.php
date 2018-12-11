<?php
/**
 * 开课路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/course', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseController@index'
    ])->name('admin.cultivate.course');
    Route::match(['get', 'post'], '/admin/cultivate/course/create', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseController@create'
    ])->name('admin.cultivate.course.create');
    Route::match(['get', 'post'], '/admin/cultivate/course/edit', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseController@edit'
    ])->name('admin.cultivate.course.edit');
    Route::match(['get', 'post'], '/admin/cultivate/course/remove', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseController@remove'
    ])->name('admin.cultivate.course.remove');
});
/**
 * 开课老师路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/course/teacher', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseTeacherController@index'
    ])->name('admin.cultivate.course.teacher');
    Route::match(['get', 'post'], '/admin/cultivate/course/teacher/create', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseTeacherController@create'
    ])->name('admin.cultivate.course.teacher.create');
    Route::match(['get', 'post'], '/admin/cultivate/course/teacher/edit', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseTeacherController@edit'
    ])->name('admin.cultivate.course.teacher.edit');
    Route::match(['get', 'post'], '/admin/cultivate/course/teacher/remove', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\CourseTeacherController@remove'
    ])->name('admin.cultivate.course.teacher.remove');
});