<?php

use Admin\Controllers\DashboardController;
use App\Resources\CategoriesResource;
use App\Resources\HomeResource;
use App\Resources\NewsletterResource;
use App\Resources\PodcastsResource;
use App\Resources\StaticResource;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * GENERAL ROUTES (NON RESOURCE ROUTES)
 */
$app->group('', function () {
    $this->get('/', [HomeResource::class, 'index'])->setName('home');
    $this->get('/home', [HomeResource::class, 'index'])->setName('home.index');
    $this->post('/newsletter', [NewsletterResource::class, 'store'])->setName('newsletter.store');
    $this->get('/about', [StaticResource::class, 'about'], 'about')->setName('about');
    $this->get('/contact', [StaticResource::class, 'contact'], 'contact')->setName('contact');
});


/**
 * PODCATS RESOURCE ROUTES
 */
$app->group('/podcasts', function () {
    $this->get('', [PodcastsResource::class, 'index'])->setName('podcasts.index');
    $this->get('/last', [PodcastsResource::class, 'last'])->setName('podcasts.last');
    $this->get('/{slug:[a-zA-Z0-9-]+}-{id:[0-9]+}', [PodcastsResource::class, 'show'])->setName('podcasts.show');
});


/**
 * CATEGORIES RESOURCE ROUTES
 */
$app->group('/categories', function () {
    $this->get('', [CategoriesResource::class, 'index'])->setName('categories.index');
    $this->get('/{slug:[a-zA-Z0-9-]+}-{id:[0-9]+}', [CategoriesResource::class, 'show'])->setName('categories.show');
});


/**
 * ADMIN CONTROLLERS ROUTES
 */
$app->group('/admin', function () {
    $this->get('', [DashboardController::class, 'index'])->setName('admin.index');
});


/**
 * NOT FOUND HANDLER
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $req, Response $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});
