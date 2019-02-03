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
use Core\Database\DatabaseInterface;
use Core\Database\MysqlDatabase;
use Core\Renderer\Renderer;
use Core\Renderer\RendererFactory;
use Core\Session\PHPSession;
use Core\Session\SessionInterface;
use function DI\create;
use function DI\factory;
use function DI\get;

return [
    DatabaseInterface::class => create(MysqlDatabase::class)->constructor(
        get('database.name'),
        get('database.host'),
        get('database.user'),
        get('database.pass')
    ),

    Validator::class => create(Validator::class)->constructor(false),
    Renderer::class => factory(RendererFactory::class),
    SessionInterface::class => create(PHPSession::class),

    \Monolog\Logger::class => factory(function () {
        $logger = new Monolog\Logger(get('logger.name'));
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler(
            get('logger.path'),
            get('logger.level')
        ));
        return $logger;
    })
];
