<?php

$app->get('/', 'People\IndexController:index')->setName('home');
$app->put('/', 'People\IndexController:put')->setName('update-people');
