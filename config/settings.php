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
     * @TODO fix this and make the logger active
     */
    'logger.name' => 'devscast',
    'logger.path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
    'logger.level' => \Monolog\Logger::DEBUG,

    /**
     * Views configuration
     */
    'views.path' => ROOT . DIRECTORY_SEPARATOR . "views",
    'views.cache' => !get('app.debug') ? get('views.path') . DIRECTORY_SEPARATOR . "__cache__" : false,

    /**
     * Twig extensions list
     */
    "twig.extensions" => [
        \Core\Twig\FormTwigExtension::class,
        \Core\Twig\AuthTwigExtension::class,
        \Core\Twig\AssetsTwigExtension::class,
        \Core\Twig\MetaTwigExtension::class,
        \App\Twig\QuoteTwigExtension::class,
    ]
];
