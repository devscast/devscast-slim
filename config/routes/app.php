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

/**
 * the routes of the frontend application
 * @param Application $app
 * @author bernard-ng <ngandubernard@gmail.com>
 */
return function (Application $app): void {

    // route in frontend, this one is grouped to make it easy to add a global middleware
    $app->group('', function () {
        $this->get('/', [HomeController::class, 'index'])->setName('home');
        $this->post('/newsletter', [NewsletterController::class, 'store'])->setName('newsletter.store');
        $this->get('/about', [PagesController::class, 'about'])->setName('about');
        $this->map(['GET', 'POST'], '/contact', [PagesController::class, 'contact'])->setName('contact');

        // resource routes, listing and display Podcasts
        $this->group('/podcasts', function () {
            $this->get('', [PodcastsController::class, 'index'])->setName('podcasts.index');
            $this->get('/{slug:[a-z0-9-]+}-{id:[0-9]+}', [PodcastsController::class, 'show'])->setName('podcasts.show');
        });

        // resource routes, listing and display Categories
        $this->group('/categories', function () {
            $this->get('', [CategoriesController::class, 'index'])->setName('categories.index');
            $this->get('/{slug:[a-z0-9-]+}-{id:[0-9]+}', [CategoriesController::class, 'show'])->setName('categories.show');
        });
    });
};
