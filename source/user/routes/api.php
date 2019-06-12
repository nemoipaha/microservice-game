<?php

/**
 * User api routes
 */

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api/v1',
    'middleware' => 'has_api_key'
], function(Router $router) {
    $router->get('/users', 'UserController@getUsersCollection');
    $router->get('/users/{id}', 'UserController@getSingleUser');
    $router->post('/users', 'UserController@addUser');
    $router->put('/users', 'UserController@updateUser');
    $router->delete('/users/{id}', 'UserController@deleteUser');
    $router->get('/users/{id}/location', 'UserController@getUserCurrentLocation');
    $router->post('/users/{id}/latitude/{latitude}/longitude/{longitude}', 'UserController@changeUserCurrentLocation');
    $router->get('/users/{id}/wallet', 'UserController@getUserWallet');
    // @todo refactor
    $router->post('/queue/messages', 'UserController@sendQueueMessage');
});
