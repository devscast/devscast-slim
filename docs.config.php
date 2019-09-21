<?php
/**
 * This file is part of the devcast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return new \Sami\Sami(__DIR__ . DIRECTORY_SEPARATOR . "src", [
    'title' => 'Devcast API',
    'build_dir' => __DIR__ . '/docs',
    'cache_dir' => __DIR__ . '/docs/__cache__',
    'default_opened_level' => 4,
]);
