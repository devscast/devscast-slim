<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

require(WEB_ROOT . "/index.php");

return [
    "paths" => [
        "migrations" => __DIR__ . "/data/migrations",
        "seeds" => __DIR__ . "/data/seeds"
    ],

    "environments" => [
        "default_migration_table" => getenv('DATABASE_MIGRATION_TABLE'),
        "default_database" => "development",

        "development" => [
            "adapter" => getenv('DATABASE_ADAPTER'),
            "host" => getenv('DATABASE_HOST'),
            "name" => getenv('DATABASE_NAME'),
            "user" => getenv('DATABASE_USERNAME'),
            "pass" => getenv('DATABASE_PASSWORD'),
            "port" => getenv('DATABASE_PORT'),
            "charset" => getenv('DATABASE_CHARSET'),
        ],

        "production" => [
            "adapter" => getenv('DATABASE_ADAPTER'),
            "host" => getenv('DATABASE_HOST'),
            "name" => getenv('DATABASE_NAME'),
            "user" => getenv('DATABASE_USERNAME'),
            "pass" => getenv('DATABASE_PASSWORD'),
            "port" => getenv('DATABASE_PORT'),
            "charset" => getenv('DATABASE_CHARSET'),
        ]
    ]
];
