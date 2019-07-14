<?php

/**
 * User api routes
 */

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api/v1',
], function(Router $router) {

    $router->group([
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

    $router->post('/auth/login', 'AuthController@signIn');

    $router->group([
        // jwt
        'middleware' => 'auth:api-jwt'
    ], function(Router $router) {
        $router->get('/users/me', 'AuthController@getAuthenticatedUser');
    });

    $router->group([
        // oauth2
        'middleware' => 'auth'
    ], function(Router $router) {
        $router->get('/oauth-data', 'OAuthController@getData');
        $router->get(
            '/oauth-data-scoped',
            [
                'middleware' => 'scopes:super-admin',
                'uses' => 'OAuthController@getData'
            ],
        );
    });
});
