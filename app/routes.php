<?php

$app->get('/', 'Homepage\IndexController')->setName('homepage');
$app->get('/people', 'People\ListController')->setName('people/index');
$app->get('/people/create', 'People\CreateController')->setName('people/create');
$app->post('/people/create-post', 'People\CreateController:createPost')->setName('people/create-post');
$app->delete('/people/remove/{uuid}', 'People\DeleteController')->setName('people/delete');
