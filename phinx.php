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
            "pass" => '',
            "port" => 3306,
            "charset" =>  "utf8",
        ],

        "production" => [
            "adapter" => 'mysql',
            "host" => "localhost",
            "name" => "production_db",
            "user" => "root",
            "pass" => '',
            "port" => 3306,
            "charset" =>  "utf8",
        ]
    ]
];