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

Route::get('/', 'HomeController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/colaboradores', 'HomeController@showColaboradores')->name('colaboradores');

Route::post('/login_ldap', 'LoginController@Login');

Route::post('importExcel', 'ExcelController@import');
Route::post('exportExcel', 'ExcelController@export');

Route::resource('plantilla', 'PlantillaController');

Route::get('importExcel', function(){

    return redirect()->action('HomeController@index');
});

Route::get('/api/colaboradores', 'HomeController@listColaboradores')->name('api_colaboradores');