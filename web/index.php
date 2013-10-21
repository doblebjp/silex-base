<?php

use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use SilexMax\Provider\TemplatingServiceProvider;
use SilexMax\Provider\OrmServiceProvider;
use SilexMax\Provider\FormServiceProvider;

$app = require __DIR__ . '/../src/app.php';

$app->register(new SessionServiceProvider());
$app->register(new TemplatingServiceProvider());
$app->register(new MonologServiceProvider());
$app->register(new OrmServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app->mount('/', new App\ControllerProvider());

$app->run();
