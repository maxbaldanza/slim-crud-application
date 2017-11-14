<?php

use Ramsey\Uuid\Doctrine\UuidType;

\Doctrine\DBAL\Types\Type::addType(UuidType::NAME, UuidType::class);

return [
    'settings' => [
        'displayErrorDetails' => getenv('DEVELOPMENT_MODE'),
        'view' => [
            'template_path' => 'app/templates',
            'twig_options' => [
                'cache' => 'cache/twig',
                'debug' => getenv('DEVELOPMENT_MODE'),
                'auto_reload' => true,
            ],
        ],
        'doctrine' => [
            'meta' => [
                'entity_path' => [
                    'app/src/Entity'
                ],
                'auto_generate_proxies' => true,
                'proxy_dir' =>  __DIR__. '/../cache/proxies',
                'cache' => null,
            ],
            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => '172.19.0.2',
                'dbname' => 'crud',
                'user' => 'root',
                'password' => 'root',
                'port' => 3306
            ]
        ]
    ],
];
