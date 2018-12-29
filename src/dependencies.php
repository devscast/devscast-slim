<?php

use App\Database\DatabaseInterface;
use App\Database\MysqlDatabase;
use Awurth\SlimValidation\Validator;
use function DI\create;
use function DI\get;

return [
    DatabaseInterface::class => create(MysqlDatabase::class)->constructor(
        get('database.name'),
        get('database.host'),
        get('database.user'),
        get('database.pass')
    ),

    Validator::class => create(Validator::class)->constructor(false),


    \Monolog\Logger::class => \DI\factory(function () {
        $logger = new Monolog\Logger(get('logger.name'));
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler(
            get('logger.path'),
            get('logger.level')
        ));
        return $logger;
    })
];
