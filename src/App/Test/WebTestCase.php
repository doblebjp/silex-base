<?php

namespace App\Test;

use Silex\WebTestCase as SilexWebTestCase;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use SilexMax\Provider\TemplatingServiceProvider;

class WebTestCase extends SilexWebTestCase
{
    public function createApplication()
    {
        $app = require __DIR__ . '/../../app.php';
        $app['debug'] = true;

        $app->register(new SessionServiceProvider());
        $app->register(new TemplatingServiceProvider());
        $app->register(new ServiceControllerServiceProvider());

        $app['exception_handler']->disable();
        $app['session.test'] = true;

        return $app;
    }
}
