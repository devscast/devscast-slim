<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\Controllers\HomeController;
use App\Controllers\StaticController;
use App\Controllers\PodcastsController;
use App\Controllers\CategoriesController;
use App\Controllers\NewsletterController;
use App\Actions\DownloadAction;

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
        $this->get('/download', DownloadAction::class)->setName('download');
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
};
