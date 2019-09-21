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
use App\Middlewares\JsonRequestMiddleware;

/**
 * @param $app \Slim\App|\DI\Bridge\Slim\App
 * @author bernard-ng, https://bernard-ng.github.io
 */
return function ($app) {
    $app->group("/api", function () {
        $this->get("/home", [HomeResource::class, 'index'])->setName('api.index');

        $this->group("/podcasts", function () {
            $this->get("", [PodcastsResource::class, 'index'])->setName('api.podcasts.index');
            $this->get(
                '/{slug:[a-zA-Z0-9-]+}-{id:[0-9]+}',
                [PodcastsResource::class, 'show']
            )->setName('api.podcasts.show');
        });

        $this->group('/categories', function () {
            $this->get("", [CategoriesResource::class, 'index'])->setName('api.categories.index');
            $this->get(
                '/{slug:[a-zA-Z0-9-]+}-{id:[0-9]+}',
                [CategoriesResource::class, 'show']
            )->setName('api.categories.show');
        });
    })->add(EnableAPIMiddleware::class)->add(JsonRequestMiddleware::class);
};
