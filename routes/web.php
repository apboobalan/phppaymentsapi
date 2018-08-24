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


$router->post('payment', 'PaymentController@create');
$router->delete('payment', 'PaymentController@delete');
$router->post('charge', 'ChargeController@create');
$router->delete('charge', 'ChargeController@delete');
$router->get('charge', 'ChargeController@getAllCharges');
$router->get('charge/{id}', 'ChargeController@getCharge');
