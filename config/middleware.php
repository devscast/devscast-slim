<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\Application;
use Framework\Middleware\{EnableCORSMiddleware, HttpMethodMiddleware};
use Psr\Http\Message\{RequestInterface, ResponseInterface};


/**
 * registration of global middlewares
 * @param Application $app
 * @author bernard-ng <ngandubernard@gmail.com>
 */
return function (Application $app) {
    $app->options('/{routes:.+}', function (RequestInterface $request, ResponseInterface $response) {
        return $response;
    });

    $app->add(HttpMethodMiddleware::class);
    $app->add(EnableCORSMiddleware::class);
};
