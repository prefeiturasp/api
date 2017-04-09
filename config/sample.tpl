<?php

return [
    // config database
    'database.driver'=> \MongoDB\Client::class,
    'database.config' => [
        'dsn' => '{{ database_dsn }}',
    ],

    // config application
    'shortener.resources.sql.path' => __DIR__ . '/../resources/sql',
    'shortener.users.repository.class' => \SuperMae\Silex\Users\Repositories\MongoDb::class,
    'shortener.urls.repository.class' => \SuperMae\Silex\Urls\Repositories\MongoDb::class,
];
