<?php

use App\Homepage\Controller\IndexController;
use App\People\Controller\PersonCreateController;
use App\People\Controller\PersonDeleteController;
use App\People\Controller\PersonListController;
use App\People\Repository\DoctrinePeopleRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

$container = $app->getContainer();

$container['view'] = function ($c) {
    $view = new Twig(
        $c['settings']['view']['template_path'],
        $c['settings']['view']['twig_options']
    );
    $view->addExtension(new TwigExtension($c['router'], $c['request']->getUri()));

    if (getenv('DEVELOPMENT_MODE')) {
        $view->addExtension(new Twig_Extension_Debug());
    }
    return $view;
};

$container['em'] = function ($c) {
    $settings = $c['settings'];
    $config = Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['meta']['auto_generate_proxies'],
        $settings['meta']['proxy_dir'],
        $settings['meta']['cache'],
        false
    );
    return EntityManager::create($settings['doctrine']['connection'], $config);
};

//Services
$container['People\PeopleRepository'] = function ($c) {
    return new DoctrinePeopleRepository($c['em']);
};

// Controllers
$container['Homepage\IndexController'] = function ($c) {
    return new IndexController($c['view']);
};

$container['People\ListController'] = function ($c) {
    return new PersonListController($c['view'], $c['People\PeopleRepository']);
};

$container['People\CreateController'] = function ($c) {
    return new PersonCreateController($c['view'], $c['People\PeopleRepository'], $c['router']);
};

$container['People\DeleteController'] = function ($c) {
    return new PersonDeleteController($c['view'], $c['People\PeopleRepository'], $c['router']);
};
