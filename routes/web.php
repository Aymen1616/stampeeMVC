<?php
use App\Controllers;
use App\Routes\Route;



Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');
Route::get('/user/manage-users', 'UserController@manageUsers');
Route::post('/user/delete-user', 'UserController@deleteUser');

Route::get('/login', 'AuthController@index');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');




Route::get('/enchere/create', 'EnchereController@create');
Route::post('/enchere/create', 'EnchereController@store');
Route::get('/enchere/manage-encheres', 'EnchereController@manageEncheres');
Route::post('/enchere/delete-enchere/{id}', 'EnchereController@deleteEnchere');
Route::get('/enchere/edit/{id}', 'EnchereController@edit');
Route::post('/enchere/update/{id}', 'EnchereController@update');


Route::dispatch();