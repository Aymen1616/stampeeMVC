<?php
use App\Controllers;
use App\Routes\Route;



Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');
Route::get('/user/manage-users', 'UserController@manageUsers');
Route::post('/user/delete-user', 'UserController@deleteUser');
Route::get('/user/profil', 'AuthController@profil');

Route::get('/login', 'AuthController@index');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');


Route::get('/enchere/create', 'EnchereController@create');
Route::post('/enchere/create', 'EnchereController@store');
Route::get('/enchere/manage-encheres', 'EnchereController@manageEncheres');
Route::get('/enchere/edit', 'EnchereController@edit');
Route::post('/enchere/update', 'EnchereController@update');
Route::post('/enchere/delete', 'EnchereController@delete');
Route::get('/enchere/coup-de-coeur', 'EnchereController@showCoupDeCoeur');
Route::get('/enchere/show', 'EnchereController@show');
Route::get('/encheres', 'EnchereController@all');
Route::post('/enchere/place-bid', 'EnchereController@placeBid');


Route::dispatch();