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
     * TODO : DELETE ROUTES => ADD ACTIVE BOOLEANS TO ENTITIES
     */



    /**
     * AUTH ROUTES
     */
    $router->post('auth/login', 'AuthController@login');
    $router->post('auth/logout', 'AuthController@logout');
    $router->post('auth/refresh', 'AuthController@refresh');
    $router->post('auth/me', 'AuthController@me');


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

    /**
     * ESTATES ROUTES
     * GET      estates/                  => get all estates
     * GET      estates/id                => get one estate by id
     * GET      estates/attr/arg     => get estates containing argument in attribute
     * POST     estates/                  => create new estate
     * PUT      estates/id                => update estate
     */
    $router->get('estates','EstateController@getAll');
    $router->get('estates/{id}', 'EstateController@getOneById');
    $router->get('estates/{attr}/{arg}', 'EstateController@getWhere');
    $router->post('estates','EstateController@create');
    $router->put('estates/{id}', 'EstateController@update');

    /**
     * ROUTES FOR APPOINTMENTS
     */
    $router->get('appointments','AppointmentController@getAll');
    $router->get('appointments/{id_customer}/{id_employees}/{date_start}', 'AppointmentController@getOneByIDs');
    $router->get('appointments/find/{arg}', 'AppointmentController@getWhere');
    $router->post('appointments','AppointmentController@create');
    $router->put('appointments/{id_customer}/{id_employees}/{date_start}','AppointmentController@update');


});
