<?php

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/../app/config.php';

$app = new \Slim\App($settings);

require __DIR__ . '/../app/container.php';
require __DIR__ . '/../app/middleware.php';
require __DIR__ . '/../app/routes.php';

chdir(getcwd() . '/../');

$app->run();
