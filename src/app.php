<?php

require __DIR__ . '/../vendor/autoload.php';

use SilexMax\Application;
use Igorw\Silex\ConfigServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use SilexMax\Provider\TemplatingServiceProvider;
use SilexMax\Provider\OrmServiceProvider;

$app = new Application();

$app->register(new ConfigServiceProvider(__DIR__ . "/../config/global.yml", [
    'root_dir' => realpath(__DIR__ . '/..')
]));

if (file_exists($local = __DIR__ . '/../config/local.yml')) {
    $app->register(new ConfigServiceProvider($local));
}

$app->register(new SessionServiceProvider());
$app->register(new TemplatingServiceProvider());
$app->register(new MonologServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new OrmServiceProvider());
$app->register(new ServiceControllerServiceProvider());

return $app;
