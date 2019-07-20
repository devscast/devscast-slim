<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use function DI\get;
use function DI\create;
use function DI\factory;
use App\Auth\DatabaseAuth;
use Core\Renderer\Renderer;
use Core\Session\PHPSession;
use Core\Database\PDOFactory;
use Core\Session\FlashService;
use Core\Renderer\RendererFactory;
use Core\Session\SessionInterface;
use Core\Twig\AssetsTwigExtension;
use Awurth\SlimValidation\Validator;
use Core\Session\FlashServiceFactory;
use App\Repositories\QuotesRepository;
use API\Middlewares\EnableAPIMiddleware;
use App\Repositories\MetaDataRepository;
use Core\Factories\SlimCSRFGuardFactory;
use App\Middlewares\EnableCORSMiddleware;

return [
    \PDO::class => factory(PDOFactory::class),

    Validator::class            => create(Validator::class)->constructor(false),
    Renderer::class             => factory(RendererFactory::class),
    SessionInterface::class     => create(PHPSession::class),
    FlashService::class         => factory(FlashServiceFactory::class),
    MetaDataRepository::class   => create(MetaDataRepository::class)->constructor(get('data.meta')),
    QuotesRepository::class     => create(QuotesRepository::class)->constructor(get('data.quotes')),

    \Slim\Csrf\Guard::class         => factory(SlimCSRFGuardFactory::class),
    \Core\Auth\AuthInterface::class => get(DatabaseAuth::class),
    AssetsTwigExtension::class      => create(AssetsTwigExtension::class)->constructor(get('app.cacheBusting')),

    EnableCORSMiddleware::class     => create(EnableCORSMiddleware::class)->constructor(get('CORS.allowOrigin')),
    EnableAPIMiddleware::class      => create(EnableAPIMiddleware::class)->constructor(get('API.enable')),
];
