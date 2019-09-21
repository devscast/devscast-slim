<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


use Framework\Middlewares\LoggedInMiddleware;
use App\Backend\Controllers\AuthController;
use App\Backend\Controllers\UsersController;
use App\Backend\Controllers\DashboardController;
use App\Backend\Controllers\FileBrowserController;
use App\Backend\Controllers\PodcastLinksController;
use App\Backend\Controllers\GalleryController;
use App\Backend\Controllers\PodcastsController;
use App\Backend\Controllers\CategoriesController;
use App\Backend\Controllers\NewsletterController;

/**
 * @param $app Slim\App|DI\Bridge\Slim\App
 * @author bernard-ng, https://bernard-ng.github.io
 */
return function ($app) {

    $this->map(['GET', 'POST'], '/login', [AuthController::class, 'login'])->setName('auth.login');
    $this->post('/logout', [AuthController::class, 'logout'])->setName('auth.logout');

    /**
     * ADMIN CONTROLLERS ROUTES
     */
    $app->group('/admin', function () {
        $this->get('', [DashboardController::class, 'index'])->setName('admin.index');
        $this->group('/podcasts', function () {
            $this->get('', [PodcastsController::class, 'index'])->setName('admin.podcasts');
            $this->map(
                ['GET', 'POST'],
                '/create',
                [PodcastsController::class, 'create']
            )->setName('admin.podcasts.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [PodcastsController::class, 'update']
            )->setName('admin.podcasts.update');

            $this->delete(
                '/{id:[0-9]+}',
                [PodcastsController::class, 'delete']
            )->setName('admin.podcasts.delete');
        });

        $this->group('/categories', function () {
            $this->get('', [CategoriesController::class, 'index'])->setName('admin.categories');

            $this->map(
                ['GET', 'POST'],
                '/create',
                [CategoriesController::class, 'create']
            )->setName('admin.categories.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [CategoriesController::class, 'update']
            )->setName('admin.categories.update');

            $this->delete(
                '/{id:[0-9]+}',
                [CategoriesController::class, 'delete']
            )->setName('admin.categories.delete');
        });

        $this->group('/gallery', function () {
            $this->get('', [GalleryController::class, 'index'])->setName('admin.gallery');
            $this->map(
                ['GET', 'POST'],
                '/create',
                [GalleryController::class, 'create']
            )->setName('admin.gallery.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [GalleryController::class, 'update']
            )->setName('admin.gallery.update');

            $this->delete(
                '/{id:[0-9]+}',
                [GalleryController::class, 'delete']
            )->setName('admin.gallery.delete');
        });

        $this->group('/podcast-links', function () {
            $this->get('', [PodcastLinksController::class, 'index'])->setName('admin.podcastLinks');
            $this->map(
                ['GET', 'POST'],
                '/create',
                [PodcastLinksController::class, 'create']
            )->setName('admin.podcastLinks.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [PodcastLinksController::class, 'update']
            )->setName('admin.podcastLinks.update');

            $this->delete(
                '/{id:[0-9]+}',
                [PodcastLinksController::class, 'delete']
            )->setName('admin.podcastLinks.delete');
        });

        $this->group('/users', function () {
            $this->get('', [UsersController::class, 'index'])->setName('admin.users');
            $this->map(
                ['GET', 'POST'],
                '/create',
                [UsersController::class, 'create']
            )->setName('admin.users.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [UsersController::class, 'update']
            )->setName('admin.users.update');

            $this->delete('/{id:[0-9]+}', [UsersController::class, 'delete'])->setName('admin.users.delete');
        });

        $this->group('/newsletter', function () {
            $this->get('', [NewsletterController::class, 'index'])->setName('admin.newsletter');
            $this->get(
                '/create',
                [NewsletterController::class, 'create']
            )->setName('admin.newsletter.create');

            $this->post(
                '/send',
                [NewsletterController::class, 'send']
            )->setName('admin.newsletter.send');

            $this->delete(
                '/{id:[0-9]+}',
                [NewsletterController::class, 'delete']
            )->setName('admin.newsletter.delete');
        });

        $this->group('/files', function () {
            $this->map(
                ['GET', 'DELETE'],
                '/audio',
                [FileBrowserController::class, 'audio']
            )->setName('admin.files.audio');

            $this->map(
                ['GET', 'DELETE'],
                '/images',
                [FileBrowserController::class, 'images']
            )->setName('admin.files.images');
        });
    })->add(LoggedInMiddleware::class);
};
