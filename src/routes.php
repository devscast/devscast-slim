<?php

use App\Resources\CategoriesResource;
use App\Resources\HomeResource;
use App\Resources\PodcastsResource;

/*$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function($req, $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});*/


$app->get('/home', [HomeResource::class, 'index'])->setName('home');


/**
 * PODCATS RESOURCE ROUTES
 */
$app->get('/podcasts', [PodcastsResource::class, 'index'])->setName('podcasts.index');
$app->get('/podcasts/last', [PodcastsResource::class, 'last'])->setName('podcasts.last');
$app->get('/podcasts/{slug}-{id}', [PodcastsResource::class, 'show'])->setName('podcasts.show');


/**
 * CATEGORIES RESOURCE ROUTES
 */
$app->get('/categories', [CategoriesResource::class, 'index'])->setName('categories.index');
$app->get('/categories/{id:[0-9]+}', [CategoriesResource::class, 'show'])->setName('categories.show');