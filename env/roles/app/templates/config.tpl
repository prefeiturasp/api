<?php

return [
    // config database
    'database.driver'=> \MongoDB\Client::class,
    'database.config' => [
        'dsn' => 'mongodb://127.0.0.1/supermae',
    ],
    'debug'=>true,
    // config application
    'supermae.gestations.repository.class' => \SuperMae\Silex\Gestations\Repositories\MongoDb::class,
];
