<?php

/**
 * User api routes
 */

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api/v1',
], function(Router $router) {
    $router->get('/secrets/closest', 'LocationController@getClosestSecrets');
});
