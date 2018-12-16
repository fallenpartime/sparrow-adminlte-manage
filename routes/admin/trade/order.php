<?php
/**
 * 订单路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/trade/order', [
        'uses' => '\App\Http\Admin\Controllers\Trade\OrderController@index'
    ])->name('admin.trade.order');
});