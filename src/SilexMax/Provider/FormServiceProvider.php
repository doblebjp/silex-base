<?php

namespace SilexMax\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\FormServiceProvider as SilexFormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmExtension;
use Dominikzogg\Silex\Provider\DoctrineOrmManagerRegistryProvider as ManagerRegistryServiceProvider;

class FormServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new SilexFormServiceProvider());
        $app->register(new ValidatorServiceProvider());
        $app->register(new ManagerRegistryServiceProvider());

        $app['form.extensions'] = $app->share($app->extend('form.extensions', function ($extensions, $app) {
            $extensions[] = new DoctrineOrmExtension($app['doctrine']);

            return $extensions;
        }));
    }

    public function boot(Application $app)
    {
    }
}
