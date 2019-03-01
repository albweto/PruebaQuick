<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});



$router->post('login',['uses'=>'UserController@login']);

$router->group(['middleware'=>['auth']],function () use ($router){
    $router->get('users',['uses'=>'UserController@list']);
    $router->put('users/{id}',['uses'=>'UserController@update']);
    $router->delete('users/{id}',['uses'=>'UserController@delete']);
    $router->get('users/{id}',['uses'=>'UserController@findUser']);
    $router->post('users',['uses'=>'UserController@create']);
});