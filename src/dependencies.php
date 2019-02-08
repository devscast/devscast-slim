<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Awurth\SlimValidation\Validator;
use Core\Renderer\Renderer;
use Core\Renderer\RendererFactory;
use Core\Session\PHPSession;
use Core\Session\SessionInterface;
use function DI\create;
use function DI\factory;
use function DI\get;

return [
    \PDO::class => factory(\Core\Database\PDOFactory::class),

    Validator::class => create(Validator::class)->constructor(false),
    Renderer::class => factory(RendererFactory::class),
    SessionInterface::class => create(PHPSession::class),

    \Slim\Csrf\Guard::class => factory(Core\Factories\SlimCSRFGuardFactory::class),

    'logger' => factory(function () {
        $logger = new Monolog\Logger(get('logger.name'));
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler(
            get('logger.path'),
            get('logger.level')
        ));
        return $logger;
    })
];
