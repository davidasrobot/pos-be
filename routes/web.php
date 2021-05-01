<?php

/** @var \Laravel\Lumen\Routing\Router $router */
$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');

$router->get('/account', [
    'middleware' => ['auth', 'cors'],
    'uses' => 'AuthController@account'
]);

$router->group(['middleware' => 'auth'], function() use ($router) {
    // user
    $router->get('/user', 'UserController@index');
    $router->get('/user/{id}', 'UserController@show');
    $router->post('/user/{id}', 'UserController@update');
    $router->post('/user/password/{id}', 'UserController@update_password');
    $router->delete('/user/{id}', 'UserController@destroy');

    // categories
    $router->get('/category', 'CategoryController@index');
    $router->get('/category/{id}', 'CategoryController@show');
    $router->post('/category', 'CategoryController@store');
    $router->post('/category/{id}', 'CategoryController@update');
    $router->delete('/category/{id}', 'CategoryController@destroy');

    // products
    $router->get('/product', 'ProductController@index');
    $router->post('/product', 'ProductController@store');
    $router->get('/product/{id}', 'ProductController@show');
    $router->post('/product/{id}', 'ProductController@update');
    $router->delete('/product/{id}', 'ProductController@destroy');

    // transactions
    $router->get('/transaction', 'TransactionController@index');
    $router->post('/transaction', 'TransactionController@store');
    $router->get('/transaction/{id}', 'TransactionController@show');
    $router->post('/transaction/{id}', 'TransactionController@update');
    $router->delete('/transaction/{id}', 'TransactionController@destroy');

    // customer
    $router->get('/customer', 'CustomerController@index');
    $router->post('/customer', 'CustomerController@store');
    $router->get('/customer/{id}', 'CustomerController@show');
    $router->post('/customer/{id}', 'CustomerController@update');
    $router->delete('/customer/{id}', 'CustomerController@destroy');
});
