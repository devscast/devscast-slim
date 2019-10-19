<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */


use App\{Middlewares\EnableAPIMiddleware, Application};
use API\Resources\{CategoriesResource, HomeResource, PodcastsResource};

/**
 * the routes of the API application
 * @param Application $app
 * @todo Secure this API
 * @author bernard-ng <ngandubernard@gmail.com>
 */
return function (Application $app) {
    $app->group("/api/v1/", function () {

        $this->get('home', [HomeResource::class, 'index'])->setName('api.v1.home');

        // Podcasts Resource
        $this->get('podcasts', [PodcastsResource::class, 'index'])->setName('api.v1.podcasts');
        $this->get(
            'podcasts/{slug:[a-z0-9-]+}-{id:[0-9]+}',
            [PodcastsResource::class, 'index']
        )->setName('api.v1.podcasts.show');

        // Categories Resource
        $this->get('categories', [CategoriesResource::class, 'index'])->setName('api.v1.categories');
        $this->get(
            'categories/{slug:[a-z0-9-]+}-{id:[0-9]+}',
            [CategoriesResource::class, 'index']
        )->setName('api.v1.categories.show');

    })->add(EnableAPIMiddleware::class);
};
