<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use API\Middlewares\EnableAPIMiddleware;
use App\Authenticators\DatabaseAuthenticator;
use App\Middlewares\EnableCORSMiddleware;
use Awurth\SlimValidation\Validator;
use Framework\Auth\AuthInterface;
use Framework\Database\DatabaseInterface;
use Framework\Database\Mysql\MysqlDatabase;
use Framework\Database\Mysql\MysqlPDOFactory;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\Twig\Extensions\AssetsTwigExtension;
use Framework\Renderer\Twig\TwigRenderer;
use Framework\Renderer\Twig\TwigRendererFactory;
use Framework\Session\FlashMessage;
use Framework\Session\FlashMessageFactory;
use Framework\Session\PHPSession;
use Framework\Session\SessionInterface;
use function DI\get;
use function DI\create;
use function DI\factory;

return [

    // Renderer
    RendererInterface::class => get(TwigRenderer::class),
    TwigRenderer::class => factory(TwigRendererFactory::class),

    // Database
    PDO::class => factory(MysqlPDOFactory::class),
    DatabaseInterface::class => get(MysqlDatabase::class),
    Validator::class => create(Validator::class)->constructor(false),

    // Session
    SessionInterface::class => create(PHPSession::class),
    FlashMessage::class => factory(FlashMessageFactory::class),

    // Authentication
    AuthInterface::class => get(DatabaseAuthenticator::class),

    // Twig Extensions
    AssetsTwigExtension::class => create(AssetsTwigExtension::class)
        ->constructor(evalbool(getenv('APP_CACHEBUSTING'))),

    // Middlewares
    EnableCORSMiddleware::class => create(EnableCORSMiddleware::class)->constructor(get('CORS.allowOrigin')),
    EnableAPIMiddleware::class => create(EnableAPIMiddleware::class)
        ->constructor(evalBool(getenv('API_ENABLE'))),
];
