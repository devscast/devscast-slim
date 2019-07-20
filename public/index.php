<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\App;
use Slim\Exception\MethodNotAllowedException;
use Slim\Exception\NotFoundException;

require(dirname(__DIR__) . '/vendor/autoload.php');
require(dirname(__DIR__) . '/config/constants.php');
try {
    $app = new App();
    $app->setup()->run();
} catch (MethodNotAllowedException | NotFoundException | Exception $e) {
    Core\Logger::error($e->getMessage(), [$e->getTraceAsString()]);
    switch (gettype($e)) {
        case MethodNotAllowedException::class:
            return http_response_code(Slim\Http\StatusCode::HTTP_METHOD_NOT_ALLOWED);
            break;
        case NotFoundException::class:
            return http_response_code(Slim\Http\StatusCode::HTTP_NOT_FOUND);
            break;
        default:
            return http_response_code(Slim\Http\StatusCode::HTTP_INTERNAL_SERVER_ERROR);
            break;
    }
}
