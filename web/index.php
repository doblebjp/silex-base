<?php

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('App', __DIR__ . '/../src');

use App\Setup;

$app = Setup::createApplication();
Setup::registerServices($app);
Setup::loadConfig($app, __DIR__ . '/../config', [
    'root_dir' => realpath(__DIR__ . '/..')
]);
Setup::mountControllers($app);

$app->run();
