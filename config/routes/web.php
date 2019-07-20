<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Controllers\HomeController;
use Admin\Controllers\AuthController;
use App\Controllers\StaticController;
use Admin\Controllers\UsersController;
use Core\Middlewares\LoggedInMiddleware;
use Admin\Controllers\PodcastsController;
use Admin\Controllers\DashboardController;
use Admin\Controllers\CategoriesController;
use Admin\Controllers\NewsletterController;
use Admin\Controllers\FileBrowserController;
use Admin\Controllers\PodcastLinksController;
use Admin\Controllers\GalleryController as AdminGalleryController;
use App\Controllers\PodcastsController as AdminPodcastsController;
use App\Controllers\CategoriesController as AdminCategoriesController;
use App\Controllers\NewsletterController as AdminNewsletterController;

/**
 * @param $app Slim\App|DI\Bridge\Slim\App
 * @author bernard-ng, https://bernard-ng.github.io
 */
return function ($app) {
    /**
     * GENERAL ROUTES (NON Controller ROUTES)
     */
    $app->group('', function () {
        $this->get('/', [HomeController::class, 'index'])->setName('home');
        $this->get('/home', [HomeController::class, 'index'])->setName('home.index');
        $this->post('/newsletter', [NewsletterController::class, 'store'])->setName('newsletter.store');
        $this->get('/about', [StaticController::class, 'about'])->setName('about');
        $this->map(['GET', 'POST'], '/contact', [StaticController::class, 'contact'])->setName('contact');
        $this->get('/search', [])->setName('search');

        $this->map(['GET', 'POST'], '/login', [AuthController::class, 'login'])->setName('auth.login');
        $this->post('/logout', [AuthController::class, 'logout'])->setName('auth.logout');
    });


    /**
     * PODCATS Controller ROUTES
     */
    $app->group('/podcasts', function () {
        $this->get('', [PodcastsController::class, 'index'])->setName('podcasts.index');
        $this->get('/last', [PodcastsController::class, 'last'])->setName('podcasts.last');
        $this->get(
            '/{slug:[a-zA-Z0-9-]+}-{id:[0-9]+}',
            [PodcastsController::class, 'show']
        )->setName('podcasts.show');
    });


    /**
     * CATEGORIES Controller ROUTES
     */
    $app->group('/categories', function () {
        $this->get('', [CategoriesController::class, 'index'])->setName('categories.index');
        $this->get(
            '/{slug:[a-zA-Z0-9-]+}-{id:[0-9]+}',
            [CategoriesController::class, 'show']
        )->setName('categories.show');
    });


    /**
     * ADMIN CONTROLLERS ROUTES
     */
    $app->group('/admin', function () {
        $this->get('', [DashboardController::class, 'index'])->setName('admin.index');
        $this->group('/podcasts', function () {
            $this->get('', [AdminPodcastsController::class, 'index'])->setName('admin.podcasts');
            $this->map(
                ['GET', 'POST'],
                '/create',
                [AdminPodcastsController::class, 'create']
            )->setName('admin.podcasts.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [AdminPodcastsController::class, 'update']
            )->setName('admin.podcasts.update');

            $this->delete(
                '/{id:[0-9]+}',
                [AdminPodcastsController::class, 'delete']
            )->setName('admin.podcasts.delete');
        });

        $this->group('/categories', function () {
            $this->get('', [AdminCategoriesController::class, 'index'])->setName('admin.categories');

            $this->map(
                ['GET', 'POST'],
                '/create',
                [AdminCategoriesController::class, 'create']
            )->setName('admin.categories.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [AdminCategoriesController::class, 'update']
            )->setName('admin.categories.update');

            $this->delete(
                '/{id:[0-9]+}',
                [AdminCategoriesController::class, 'delete']
            )->setName('admin.categories.delete');
        });

        $this->group('/gallery', function () {
            $this->get('', [AdminGalleryController::class, 'index'])->setName('admin.gallery');
            $this->map(
                ['GET', 'POST'],
                '/create',
                [AdminGalleryController::class, 'create']
            )->setName('admin.gallery.create');

            $this->map(
                ['GET', 'PUT'],
                '/{id:[0-9]+}',
                [AdminGalleryController::class, 'update']
            )->setName('admin.gallery.update');

            $this->delete(
                '/{id:[0-9]+}',
                [AdminGalleryController::class, 'delete']
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
            $this->get('', [AdminNewsletterController::class, 'index'])->setName('admin.newsletter');
            $this->get(
                '/create',
                [AdminNewsletterController::class, 'create']
            )->setName('admin.newsletter.create');

            $this->post(
                '/send',
                [AdminNewsletterController::class, 'send']
            )->setName('admin.newsletter.send');

            $this->delete(
                '/{id:[0-9]+}',
                [AdminNewsletterController::class, 'delete']
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
