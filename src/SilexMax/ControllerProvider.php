<?php

namespace SilexMax;

use Silex\Application as SilexApp;
use Silex\ControllerProviderInterface;

class ControllerProvider implements ControllerProviderInterface
{
    public function connect(SilexApp $app)
    {
        $controllers = $app['controllers_factory'];

        $app['test.controller'] = $app->share(function () use ($app) {
            $controller = new Controller\TestController();
            $controller->setTwig($app['twig']);

            return $controller;
        });

        $controllers->get('/', 'test.controller:test')
            ->bind('homepage');

        return $controllers;
    }
}
