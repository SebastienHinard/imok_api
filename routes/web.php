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
$router->group(['prefix' => 'api'], function () use ($router) {


    /**
     * AUTH ROUTES
     */
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('refresh', 'AuthController@refresh');
    $router->post('me', 'AuthController@me');


    /**
     * CUSTOMER ROUTES
     * GET      customers/                  => get all customers
     * GET      customers/id                => get one customer by id
     * GET      customers/find/argument     => get customers containing argument in mail / firstname / lastname
     * POST     customers/                  => create new customer
     * PUT      customers/id                => update customer
     */
    $router->get('customers','CustomerController@getAll');
    $router->get('customers/{id}', 'CustomerController@getOneById');
    $router->get('customers/find/{arg}', 'CustomerController@getWhere');
    $router->post('customers','CustomerController@create');
    $router->put('customers/{id}', 'CustomerController@update');
});
