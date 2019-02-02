<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// Application middleware


use Slim\Http\Request;
use Slim\Http\Response;

$app->options('/{routes:.+}', function (Request $request, Response $response, array $args) {
    return $response;
});

$app->add(\App\Middlewares\JsonRequestMiddleware::class);
$app->add(\App\Middlewares\EnableCORSMiddleware::class);
