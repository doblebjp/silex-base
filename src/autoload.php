<?php

($loader = @include __DIR__ . '/../../../../vendor/autoload.php') || ($loader = @include __DIR__ . '/../vendor/autoload.php');
$loader->add('App', __DIR__);

return $loader;
