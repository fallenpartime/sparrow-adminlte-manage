<?php
Route::middleware(['web'])->group(function () {
    Route::get('/admin/demo/index', [
        'as' => 'admin.demo',
        'uses' => '\App\Http\Admin\Controllers\DemoController@index'
    ]);
});