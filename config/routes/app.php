<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\Application;
use Modules\Page\HomeController;
use Modules\Page\PagesController;
use Modules\Podcast\Category\CategoriesController;
use Modules\Podcast\Newsletter\NewsletterController;
use Modules\Podcast\PodcastsController;

return function (Application $app): void {

    /**
     * GENERAL ROUTES (NON Controller ROUTES)
     */
    $app->group('', function () {
        $this->get('/', [HomeController::class, 'index'])->setName('home');
        $this->get('/home', [HomeController::class, 'index'])->setName('home.index');
        $this->post('/newsletter', [NewsletterController::class, 'store'])->setName('newsletter.store');
        $this->get('/about', [PagesController::class, 'about'])->setName('about');
        $this->map(['GET', 'POST'], '/contact', [PagesController::class, 'contact'])->setName('contact');
        //$this->get('/search', [])->setName('search');
        //$this->get('/download', DownloadAction::class)->setName('download');
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
