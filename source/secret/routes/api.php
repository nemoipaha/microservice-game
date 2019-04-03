<?php

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api/v1',
], function(Router $router) {
    $router->get('/secrets', 'SecretController@getSecretCollection');
    $router->get('/secrets/{id}', 'SecretController@getSecretById');
    $router->post('/secrets', 'SecretController@newSecret');
});
