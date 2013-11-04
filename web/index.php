<?php

require __DIR__ . '/../src/autoload.php';

use App\Setup;

$app = Setup::createApplication();
Setup::registerServices($app);
Setup::loadConfig($app, __DIR__ . '/../config', [
    'root_dir' => realpath(__DIR__ . '/..')
]);
Setup::mountControllers($app);

$app->run();
