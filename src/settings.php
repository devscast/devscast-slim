<?php
return [

    /**
     * Slim Framework Configurations
     */
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => true,

    /**
     * Logger configurations
     */
    'logger.name' => 'devcast',
    'logger.path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
    'logger.level' => \Monolog\Logger::DEBUG,


    /**
     * Database configurations
     */
    'database.name' => 'devcast',
    'database.host' => 'localhost',
    'database.user' => 'root',
    'database.pass' => '',
];
