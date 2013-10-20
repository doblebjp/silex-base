<?php

namespace App;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApp $app)
    {
        $controllers = $app['controllers_factory'];

        $app['test.controller'] = $app->share(function () use ($app) {
            return new Controller\TestController();
        });

        $controllers->get('/', 'test.controller:test')
            ->bind('homepage');

        $controllers->match('/form-horizontal', 'test.controller:testFormHorizontal')
            ->bind('form_horizontal');

        return $controllers;
    }
}
