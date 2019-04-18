<?php
require(__DIR__. "/public/index.php");

return [
    "paths" => [
        "migrations" => __DIR__ . "/data/migrations",
        "seeds" => __DIR__ . "/data/seeds"
    ],

    "environments" => [
        "default_migration_table" => "phinxlog",
        "default_database" => "development",

        "development" => [
            "adapter" => 'mysql',
            "host" => 'localhost',
            "name" => "devcast",
            "user" => "root",
            "pass" => 'root',
            "port" => 3306,
            "charset" =>  "utf8",
        ],

        "production" => [
            "adapter" => 'mysql',
            "host" => $app->getContainer()->get('database.host'),
            "name" => $app->getContainer()->get('database.name'),
            "user" => $app->getContainer()->get('database.username'),
            "pass" => $app->getContainer()->get('database.password'),
            "port" => 3306,
            "charset" =>  "utf8",
        ]
    ]
];
