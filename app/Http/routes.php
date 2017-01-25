<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
    'as' => 'home',
    'uses' => 'PagesController@home'
]);

Route::resource('categorias', 'CategoriaController');
Route::get('/categorias/{categorias}/delete', [
	'as' => 'categorias.delete',
	'uses' => 'CategoriaController@delete'
]);

Route::resource('seguros', 'SeguroController');
Route::get('/seguros/{seguros}/delete', [
	'as' => 'seguros.delete',
	'uses' => 'SeguroController@delete'
]);

Route::resource('atributos', 'AtributoController');
Route::get('/atributos/{atributos}/delete', [
	'as' => 'atributos.delete',
	'uses' => 'AtributoController@delete'
]);

// Authentication Routes...
Route::get('login', [
	'as' => 'login',
	'uses' => 'Auth\AuthController@showLoginForm'
]);

Route::post('login', [
	'as' => 'post.login',
	'uses' => 'Auth\AuthController@login'
]);

Route::get('logout', [
	'as' => 'logout',
	'uses' => 'Auth\AuthController@logout'
]);

// Registration Routes...
Route::get('__private_register', 'Auth\AuthController@showRegistrationForm');
Route::post('__private_register', 'Auth\AuthController@register');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');
