<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use App\Twig\QuoteTwigExtension;
use Framework\Twig\AssetsTwigExtension;
use Framework\Twig\AuthTwigExtension;
use Framework\Twig\FlashTwigExtension;
use Framework\Twig\FormTwigExtension;
use Framework\Twig\MetaTwigExtension;
use function DI\get;

return [
    /**
     * Views configuration
     */
    'views.path' => ROOT . DIRECTORY_SEPARATOR . "views",
    'views.cache' => !getenv('APP_ENV') === 'dev'
        ? get('views.path') . DIRECTORY_SEPARATOR . "__cache__"
        : false,

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
