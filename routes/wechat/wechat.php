<?php
/**
 * 微信路由
 */
Route::middleware(['web'])->group(function () {
    // 服务
    Route::match(['get', 'post'], '/wechat', [
        'uses' => '\App\Http\Wechat\Controllers\WechatController@service'
    ])->name('wechat.service');
});

Route::middleware(['web', 'wechat.oauth:snsapi_userinfo'])->group(function () {
    // 前台授权登录
//    Route::any('/wechat/oauth/front', [
//        'uses' => '\App\Http\Wechat\Controllers\Oauth\OauthController@front'
//    ])->name('wechat.oauth.front');
    // 后台授权登录
    Route::any('/wechat/oauth/admin', [
        'uses' => '\App\Http\Wechat\Controllers\OauthController@admin'
    ])->name('wechat.oauth.admin');
});