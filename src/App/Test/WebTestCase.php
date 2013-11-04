<?php

namespace App\Test;

Use App\Setup;
use Silex\WebTestCase as SilexWebTestCase;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use SilexMax\Provider\TemplatingServiceProvider;

class WebTestCase extends SilexWebTestCase
{
    public function createApplication()
    {
        $app = Setup::createApplication();

        $app->register(new SessionServiceProvider());
        $app->register(new TemplatingServiceProvider());
        $app->register(new ServiceControllerServiceProvider());

        Setup::loadConfig($app, __DIR__ . '/../../../config', [
            'root_dir' => realpath(__DIR__ . '/../../..')
        ]);

        $app['debug'] = true;
        $app['exception_handler']->disable();
        $app['session.test'] = true;

        return $app;
    }
}
