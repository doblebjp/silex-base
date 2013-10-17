<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use SilexMax\Provider\OrmServiceProvider;

$app = require __DIR__ . '/../src/app.php';

$app->register(new OrmServiceProvider());

return ConsoleRunner::createHelperSet($app['orm.em']);
