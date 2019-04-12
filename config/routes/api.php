<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use API\Middlewares\EnableAPIMiddleware;
use App\Middlewares\JsonRequestMiddleware;

/**
 * @param $app \Slim\App|\DI\Bridge\Slim\App
 */
return function ($app) {

    $app->group("/api", function () {
        $this->get("/home", [\API\Resources\HomeResource::class, 'index'])->setName('api.index');

    })->add(EnableAPIMiddleware::class)->add(JsonRequestMiddleware::class);
};