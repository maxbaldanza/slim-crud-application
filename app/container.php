<?php

use App\People\Controller\IndexController;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$container = $app->getContainer();

$container['view'] = function ($c) {
    $view = new Twig(
        $c['settings']['view']['template_path'],
        $c['settings']['view']['twig_options']
    );
    $view->addExtension(new TwigExtension($c['router'], $c['request']->getUri()));
    return $view;
};

$container['People\IndexController'] = function ($c) {
    $view = $c['view'];
    return new IndexController($view);
};
