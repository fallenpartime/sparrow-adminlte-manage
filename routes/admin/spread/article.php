<?php
/**
 * 文章路由
 */
Route::middleware(['web', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/spread/article', [
        'uses' => '\App\Http\Admin\Controllers\Spread\ArticleController@index'
    ])->name('admin.spread.article');
    Route::match(['get', 'post'], '/admin/spread/article/create', [
        'uses' => '\App\Http\Admin\Controllers\Spread\ArticleController@create'
    ])->name('admin.spread.article.create');
    Route::match(['get', 'post'], '/admin/spread/article/edit', [
        'uses' => '\App\Http\Admin\Controllers\Spread\ArticleController@edit'
    ])->name('admin.spread.article.edit');
    Route::match(['post'], '/admin/spread/article/remove', [
        'uses' => '\App\Http\Admin\Controllers\Spread\ArticleController@remove'
    ])->name('admin.spread.article.remove');
    Route::match(['post'], '/admin/spread/article/show', [
        'uses' => '\App\Http\Admin\Controllers\Spread\ArticleController@show'
    ])->name('admin.spread.article.show');
    Route::match(['post'], '/admin/spread/article/publish', [
        'uses' => '\App\Http\Admin\Controllers\Spread\ArticleController@publish'
    ])->name('admin.spread.article.publish');
});