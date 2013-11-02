<?php

$app = require __DIR__ . '/../src/app.php';

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\MonologServiceProvider());
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

$app->register(new SilexMax\Provider\TemplatingServiceProvider());
$app->register(new SilexMax\Provider\OrmServiceProvider());
$app->register(new SilexMax\Provider\FormServiceProvider());

$app->mount('/', new App\ControllerProvider());

$app->run();
