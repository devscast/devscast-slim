<?php

use Admin\Controllers\CategoriesController;
use Admin\Controllers\DashboardController;
use Admin\Controllers\GalleryController;
use Admin\Controllers\NewsletterController;
use Admin\Controllers\PodcastLinksController;
use Admin\Controllers\PodcastsController;
use Admin\Controllers\UsersController;
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

    $this->group('/podcasts', function () {
        $this->get('', [PodcastsController::class, 'index'])->setName('admin.podcasts');
        $this->get('/create', [PodcastsController::class, 'create'])->setName('admin.podcasts.create');
        $this->post('/store', [PodcastsController::class], 'store')->setName('admin.podcasts.store');
        $this->get('/{id:[0-9]}', [PodcastsController::class, 'edit'])->setName('admin.podcasts.edit');
        $this->put('/{id:[0-9]}', [PodcastsController::class, 'update'])->setName('admin.podcasts.update');
        $this->delete('/{id:[0-9]}', [PodcastsController::class, 'delete'])->setName('admin.podcasts.delete');
    });

    $this->group('/categories', function () {
        $this->get('', [CategoriesController::class, 'index'])->setName('admin.categories');
        $this->get('/create', [CategoriesController::class, 'create'])->setName('admin.categories.create');
        $this->post('/store', [CategoriesController::class, 'store'])->setName('admin.categories.store');
        $this->get('/{id:[0-9]}', [CategoriesController::class, 'edit'])->setName('admin.categories.edit');
        $this->put('/{id:[0-9]}', [CategoriesController::class, 'update'])->setName('admin.categories.update');
        $this->delete('/{id:[0-9]}', [CategoriesController::class, 'delete'])->setName('admin.categories.delete');
    });

    $this->group('/gallery', function () {
        $this->get('', [GalleryController::class, 'index'])->setName('admin.gallery');
        $this->get('/create', [GalleryController::class, 'create'])->setName('admin.gallery.create');
        $this->post('/store', [GalleryController::class, 'store'])->setName('admin.gallery.store');
        $this->get('/{id:[0-9]}', [GalleryController::class, 'edit'])->setName('admin.gallery.edit');
        $this->put('/{id:[0-9]}', [GalleryController::class, 'update'])->setName('admin.gallery.update');
        $this->delete('/{id:[0-9]}', [GalleryController::class, 'delete'])->setName('admin.gallery.delete');
    });

    $this->group('/podcast-links', function () {
        $this->get('', [PodcastLinksController::class, 'index'])->setName('admin.podcastLinks');
        $this->get('/create', [PodcastLinksController::class, 'create'])->setName('admin.podcastLinks.create');
        $this->post('/store', [PodcastLinksController::class, 'store'])->setName('admin.podcastLinks.store');
        $this->get('/{id:[0-9]}', [PodcastLinksController::class, 'edit'])->setName('admin.podcastLinks.edit');
        $this->put('/{id:[0-9]}', [PodcastLinksController::class, 'update'])->setName('admin.podcastLinks.update');
        $this->delete('/{id:[0-9]}', [PodcastLinksController::class, 'delete'])->setName('admin.podcastsLinks.delete');
    });

    $this->group('/users', function () {
        $this->get('', [UsersController::class, 'index'])->setName('admin.users');
        $this->get('/create', [UsersController::class, 'create'])->setName('admin.users.create');
        $this->post('/store', [UsersController::class, 'store'])->setName('admin.users.store');
        $this->get('/{id:[0-9]}', [UsersController::class, 'edit'])->setName('admin.users.edit');
        $this->put('/{id:[0-9]}', [UsersController::class, 'update'])->setName('admin.users.update');
        $this->delete('/{id:[0-9]}', [UsersController::class, 'delete'])->setName('admin.users.delete');
    });

    $this->group('/newsletter', function () {
        $this->get('', [NewsletterController::class, 'index'])->setName('admin.newsletter');
        $this->get('/create', [NewsletterController::class, 'create'])->setName('admin.newsletter.create');
        $this->post('/send', [NewsletterController::class, 'send'])->setName('admin.newsletter.send');
        $this->delete('/{id:[0-9]}', [NewsletterController::class, 'delete'])->setName('admin.newsletter.delete');
    });
});


/**
 * NOT FOUND HANDLER
 */
$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function (Request $req, Response $res) {
    $handler = $this->notFoundHandler;
    return $handler($req, $res);
});
