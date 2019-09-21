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
use App\Twig\QuoteTwigExtension;
use Framework\Twig\AuthTwigExtension;
use Framework\Twig\FormTwigExtension;
use Framework\Twig\MetaTwigExtension;
use Framework\Twig\FlashTwigExtension;
use Framework\Twig\AssetsTwigExtension;

return [

    /**
     * Slim Framework Configurations
     */
    'settings.responseChunkSize' => 4096,
    'settings.outputBuffering' => 'append',
    'settings.determineRouteBeforeAppMiddleware' => false,
    'settings.displayErrorDetails' => get('app.debug'),


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
     * Data Config
     */
    "data.messages" => ROOT . "/data/messages.json",
    "data.meta" => ROOT . "/data/meta.json",
    "data.quotes" => ROOT . "/data/quotes.json",
    "data.lang.en" => ROOT . "/data/lang/en.json",
    "data.lang.fr" => ROOT . "/data/lang/fr.json",


    /**
     * Twig extensions list
     */
    "twig.extensions" => [
        FormTwigExtension::class,
        AuthTwigExtension::class,
        AssetsTwigExtension::class,
        MetaTwigExtension::class,
        QuoteTwigExtension::class,
        FlashTwigExtension::class
    ]
];
