<?php

use Awurth\SlimValidation\Validator;
use Core\Database\DatabaseInterface;
use Core\Database\MysqlDatabase;
use Core\Renderer\Renderer;
use Core\Renderer\RendererFactory;
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
