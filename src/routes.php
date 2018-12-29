<?php

use App\Resources\CategoriesResource;
use App\Resources\HomeResource;
use App\Resources\NewsletterResource;
use App\Resources\PodcastsResource;
use Slim\Http\Request;
use Slim\Http\Response;


/**
 * GENERAL ROUTES (NON RESOURCE ROUTES)
 */
$app->group('', function () {
    $this->get('/home', [HomeResource::class, 'index'])->setName('home');
    $this->post('/newsletter', [NewsletterResource::class, 'store'])->setName('newsletter.store');
});


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


/**
 * NOT FOUND HANDLER
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function(Request $req, Response $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});