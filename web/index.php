<?php

$app = require __DIR__ . '/../src/app.php';

$app->mount('/', new SilexMax\ControllerProvider());

$app->run();
