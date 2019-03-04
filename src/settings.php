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

return [

    /**
     * Slim Framework Configurations
     */
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => get('app.debug'),

    /**
     * Logger configurations
     */
    'logger.name' => 'devscast',
    'logger.path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
    'logger.level' => \Monolog\Logger::DEBUG,


    /**
     * Views configuration
     */
    'views.path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . "views",
    'views.cache' => !get('app.debug') ?
        dirname(__DIR__) . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "__cache__" :
        false,
];
