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
$app->group('/podcasts', function () {
    $this->get('', [PodcastsResource::class, 'index'])->setName('podcasts.index');
    $this->get('/last', [PodcastsResource::class, 'last'])->setName('podcasts.last');
    $this->get('/{slug:[\w]+}-{id:[0-9]+}', [PodcastsResource::class, 'show'])->setName('podcasts.show');
});


/**
 * CATEGORIES RESOURCE ROUTES
 */
$app->group('/categories', function () {
    $this->get('', [CategoriesResource::class, 'index'])->setName('categories.index');
    $this->get('/{id:[0-9]+}', [CategoriesResource::class, 'show'])->setName('categories.show');
});