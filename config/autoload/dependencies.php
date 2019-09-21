<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use function DI\get;
use function DI\create;
use function DI\factory;
use App\Auth\DatabaseAuth;
use Framework\Renderer\Renderer;
use Framework\Session\PHPSession;
use Framework\Database\PDOFactory;
use Framework\Session\FlashService;
use Framework\Renderer\RendererFactory;
use Framework\Session\SessionInterface;
use Framework\Twig\AssetsTwigExtension;
use Awurth\SlimValidation\Validator;
use Framework\Session\FlashServiceFactory;
use App\Repositories\QuotesRepository;
use API\Middlewares\EnableAPIMiddleware;
use App\Repositories\MetaDataRepository;
use Framework\Factories\SlimCSRFGuardFactory;
use App\Middlewares\EnableCORSMiddleware;

return [
    \PDO::class => factory(PDOFactory::class),

    Validator::class => create(Validator::class)->constructor(false),
    Renderer::class => factory(RendererFactory::class),
    SessionInterface::class => create(PHPSession::class),
    FlashService::class => factory(FlashServiceFactory::class),
    MetaDataRepository::class => create(MetaDataRepository::class)->constructor(get('data.meta')),
    QuotesRepository::class => create(QuotesRepository::class)->constructor(get('data.quotes')),

    \Slim\Csrf\Guard::class => factory(SlimCSRFGuardFactory::class),
    \Framework\Auth\AuthInterface::class => get(DatabaseAuth::class),
    AssetsTwigExtension::class => create(AssetsTwigExtension::class)
        ->constructor(evalbool(getenv('APP_CACHEBUSTING'))),

    EnableCORSMiddleware::class => create(EnableCORSMiddleware::class)->constructor(get('CORS.allowOrigin')),
    EnableAPIMiddleware::class => create(EnableAPIMiddleware::class)
        ->constructor(evalBool(getenv('API_ENABLE'))),
];
