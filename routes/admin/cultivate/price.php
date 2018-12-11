<?php
/**
 * 报价路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/cultivate/price', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\PriceController@index'
    ])->name('admin.cultivate.price');
    Route::match(['get', 'post'], '/admin/cultivate/price/create', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\PriceController@create'
    ])->name('admin.cultivate.price.create');
    Route::match(['get', 'post'], '/admin/cultivate/price/edit', [
        'uses' => '\App\Http\Admin\Controllers\Cultivate\PriceController@edit'
    ])->name('admin.cultivate.price.edit');
});