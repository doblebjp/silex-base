<?php

namespace SilexMax\Tests;

use Silex\WebTestCase as SilexWebTestCase;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

class WebTestCase extends SilexWebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../app.php';
        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app['session.test'] = true;

        return $app;
    }
}
