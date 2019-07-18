<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Middlewares\EnableCORSMiddleware;
use Core\Middlewares\HttpMethodMiddleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @param $app Slim\App|DI\Bridge\Slim\App
 * @author bernard-ng, https://bernard-ng.github.io
 */
return function ($app) {
    $app->options('/{routes:.+}', function (RequestInterface $request, ResponseInterface $response) {
        return $response;
    });

    $app->add(HttpMethodMiddleware::class);
    $app->add(EnableCORSMiddleware::class);
};
