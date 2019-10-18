<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\Modules;
use App\Application;
use Modules\Backend\DashboardController;
use Framework\Middleware\LoggedInMiddleware;
use Modules\Backend\Podcast\{PodcastsController,
    CategoriesController,
    NewsletterController,
    PodcastLinksController};
use Modules\Backend\Controllers\FileBrowserController;
use Modules\Backend\User\{AuthController, UsersController};

/**
 * the routes of the backend application
 * @param Application $app
 * @author bernard-ng <ngandubernard@gmail.com>
 */
return function (Application $app) {

    /**
     * creates a dynamic route template to avoid code duplication
     * @param Application $app
     * @param string $module
     * @param string $controller
     * @param array $middleware
     * @return Application
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    $crud = function (Application $app, string $module, string $controller, array $middleware = []): Application {
        $group = $app->group("/admin/{$module}", function () use ($module, $controller) {
            $this->get("", [$controller, 'index'])->setName("admin.{$module}");
            $this->map(['GET', 'PUT'], '/edit/{id:[0-9]+}', [$controller, 'update'])->setName("admin.{$module}.update");
            $this->map(['GET', 'POST'], '/create', [$controller, 'create'])->setName("admin.{$module}.create");
            $this->delete('/{id:[0-9]+}', [$controller, 'delete'])->setName("admin.{$module}.delete");
        });

        foreach ($middleware as $m) $group->add($m);
        return $app;
    };

    // authentication routes for administration
    $this->map(['GET', 'POST'], '/admin-login', [AuthController::class, 'login'])->setName('admin.auth.login');
    $this->post('/admin-logout', [AuthController::class, 'logout'])->setName('admin.auth.logout');

    // middleware to be added to the CRUD route
    $adminMiddlewares = [
        LoggedInMiddleware::class
    ];

    // groups all routes by modules using the same url schema
    $crud($app, Modules::PODCASTS, PodcastsController::class, $adminMiddlewares);
    $crud($app, Modules::CATEGORIES, CategoriesController::class, $adminMiddlewares);
    $crud($app, Modules::PODCASTLINKS, PodcastLinksController::class, $adminMiddlewares);
    $crud($app, Modules::USERS, UsersController::class, $adminMiddlewares);


    // groups together the administration modules that do not have CRUD functionality
    $app->group('/admin', function () {
        $this->get('/admin', [DashboardController::class, 'index'])->setName('admin.index');

        // newsletter management, "delete" deletes a newsletter subscriber
        $this->group('/newsletter', function () {
            $this->get('', [NewsletterController::class, 'index'])->setName('admin.newsletter');
            $this->get('/create', [NewsletterController::class, 'create'])->setName('admin.newsletter.create');
            $this->post('/send', [NewsletterController::class, 'send'])->setName('admin.newsletter.send');
            $this->delete('/{id:[0-9]+}', [NewsletterController::class, 'delete'])->setName('admin.newsletter.delete');
        });

        // file system, display and manual deletion
        $this->group('/files', function () {
            $this->map(['GET', 'DELETE'], '/audio', [FileBrowserController::class, 'audio'])->setName('admin.files.audio');
            $this->map(['GET', 'DELETE'], '/images', [FileBrowserController::class, 'images'])->setName('admin.files.images');
        });
    })->add(LoggedInMiddleware::class);
};
