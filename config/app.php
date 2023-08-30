<?php

/**
 * @see bootstrap/app.php
 */

declare(strict_types=1);

return [

    'debug'    => ($_ENV['ENV'] !== 'prod') ? true : false,

    'logFile'  => ($_ENV['LOG_PATH']) ? __DIR__ . '/../' . $_ENV['LOG_PATH'] : __DIR__ . '/../temp/logs/app.log',

    'cache'    => [
        'scheme'   => $_ENV['CACHE_SCHEME'],
        'host'     => $_ENV['CACHE_HOST'],
        'port'     => $_ENV['CACHE_PORT'],
        'database' => $_ENV['CACHE_DB'],
        'password' => $_ENV['CACHE_PASS']
    ],

    'queue'    => [
        'host'     => $_ENV['QUEUE_HOST'],
        'port'     => $_ENV['QUEUE_PORT'],
        'user'     => $_ENV['QUEUE_USER'],
        'password' => $_ENV['QUEUE_PASS'],
        'vhost'    => $_ENV['QUEUE_VHOST']
    ],

    'database' => [
        'dsn'     => $_ENV['DB_CONNECTION'] . ':' . 'host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=' . $_ENV['DB_CHARSET'],
        'user'    => $_ENV['DB_USERNAME'],
        'pass'    => $_ENV['DB_PASSWORD'],
        'options' => [
                // PDO::MYSQL_ATTR_SSL_CA       => $_ENV['MYSQL_ATTR_SSL_CA'] ?? '',
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_PERSISTENT         => true
        ]
    ],

];