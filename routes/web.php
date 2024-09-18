<?php
use App\Controllers;
use App\Routes\Route;



Route::get('/user/create', 'UserController@create');
Route::post('/user/create', 'UserController@store');

Route::get('/login', 'AuthController@index');
Route::post('/login', 'AuthController@store');
Route::get('/logout', 'AuthController@delete');

Route::get('/user/manage-users', 'UserController@manageUsers');
Route::post('/user/delete-user', 'UserController@deleteUser');




Route::dispatch();