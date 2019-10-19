<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\Renderer\Twig\Extensions\QuoteTwigExtension;
use Framework\Renderer\Twig\Extensions\AssetsTwigExtension;
use Framework\Renderer\Twig\Extensions\AuthTwigExtension;
use Framework\Renderer\Twig\Extensions\FlashTwigExtension;
use Framework\Renderer\Twig\Extensions\FormTwigExtension;
use Framework\Renderer\Twig\Extensions\MetaTwigExtension;
use nochso\HtmlCompressTwig\Extension;
use Twig\Extensions\TextExtension;

use function DI\get;

return [

    // Renderer Configuration
    'renderer.views.path' => ROOT . "/views",

    // Twig Renderer Configuration
    'renderer.twig.config' => [
        'debug' => getenv('APP_ENV') === 'dev',
        'cache' => getenv('APP_ENV') === 'prod' ? ROOT . "/config/cache/renderer" : false,
        'autoreload' => getenv('APP_ENV') === 'dev',
        'strict_variables' => false,
    ],

    'renderer.twig.extensions' => [

        // Framework Extensions
        Extension::class,
        TextExtension::class,
        FormTwigExtension::class,
        AuthTwigExtension::class,
        AssetsTwigExtension::class,
        MetaTwigExtension::class,
        FlashTwigExtension::class,

        // Custom Extensions
        QuoteTwigExtension::class,
    ],

    // Twig Renderer Namespace
    'renderer.twig.paths' => [
        get('renderer.views.path'),
        'layouts' => ROOT . "/views/layouts",
        'frontend' => ROOT . "/views/frontend",
        'backend' => ROOT . "/views/backend",
        'errors' => ROOT . "/views/errors"
    ],
];
