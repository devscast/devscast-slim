<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

return [
    'database.name' => getenv('DATABASE_NAME'),
    'database.host' => getenv('DATABASE_HOST'),
    'database.username' => getenv('DATABASE_USERNAME'),
    'database.password' => getenv('DATABASE_PASSWORD'),
    'database.port' => getenv('DATABASE_PORT'),
    'database.adapter' => getenv('DATABASE_ADAPTER'),
    'database.charset' => getenv('DATABASE_CHARSET')
];
