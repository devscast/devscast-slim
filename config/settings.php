<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Twig\QuoteTwigExtension;
use Core\Twig\AssetsTwigExtension;
use Core\Twig\AuthTwigExtension;
use Core\Twig\FormTwigExtension;
use Core\Twig\MetaTwigExtension;
use function DI\get;
use Monolog\Logger;

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
    'logger.level' => Logger::DEBUG,



    /**
     * Views configuration
     */
    'views.path' => ROOT . DIRECTORY_SEPARATOR . "views",
    'views.cache' => !get('app.debug') ? get('views.path') . DIRECTORY_SEPARATOR . "__cache__" : false,



    /**
     * Allowed Origins for CORS
     */
    'CORS.allowOrigin' => [
        "http://localhost:8080"
    ],



    /**
     * Twig extensions list
     */
    "twig.extensions" => [
        FormTwigExtension::class,
        AuthTwigExtension::class,
        AssetsTwigExtension::class,
        MetaTwigExtension::class,
        QuoteTwigExtension::class,
    ]
];
