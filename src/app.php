<?php

require __DIR__ . '/../src/autoload.php';

use SilexMax\Application;
use Igorw\Silex\ConfigServiceProvider;

$app = new Application();

$app->register(new ConfigServiceProvider(__DIR__ . "/../config/global.yml", [
    'root_dir' => realpath(__DIR__ . '/..')
]));

if (file_exists($local = __DIR__ . '/../config/local.yml')) {
    $app->register(new ConfigServiceProvider($local));
}

return $app;
