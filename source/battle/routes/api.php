<?php

use Laravel\Lumen\Routing\Router;

$router->group([
    'prefix' => 'api/v1'
], function (Router $router) {
    $router->post('battle/duel', 'BattleController@duel');
});
