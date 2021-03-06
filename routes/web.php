<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
require __DIR__.'/admin/demo.php';
require __DIR__.'/admin/basic.php';
require __DIR__.'/admin/system.php';
require __DIR__.'/admin/upload.php';
require __DIR__.'/admin/school.php';
require __DIR__.'/admin/cultivate.php';
require __DIR__.'/admin/spread.php';
require __DIR__.'/admin/trade.php';
require __DIR__.'/admin/user.php';
