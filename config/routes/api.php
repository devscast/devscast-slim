<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use API\Middlewares\EnableAPIMiddleware;
use API\Resources\CategoriesResource;
use API\Resources\HomeResource;
use API\Resources\PodcastsResource;
use App\Application;
use App\Middlewares\JsonRequestMiddleware;

/**
 * the routes of the API application
 * @param Application $app
 * @todo add API routes once available, grouped by resource type
 * @author bernard-ng <ngandubernard@gmail.com>
 */
return function (Application $app) {
    $app->group("/api/v1/", function () {
        // TODO : add API routes once available, grouped by resource type
    })->add(EnableAPIMiddleware::class)->add(JsonRequestMiddleware::class);
};
