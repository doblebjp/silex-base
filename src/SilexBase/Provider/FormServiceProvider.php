<?php

namespace SilexBase\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\FormServiceProvider as SilexFormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Symfony\Bridge\Doctrine\Form\DoctrineOrmExtension;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Saxulum\DoctrineOrmManagerRegistry\Silex\Provider\DoctrineOrmManagerRegistryProvider;

class FormServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new ValidatorServiceProvider(), [
            'validator.validator_service_ids' => [
                'doctrine.orm.validator.unique' => 'unique_entity_validator'
            ]
        ]);

        $app['unique_entity_validator'] = $app->share(function () use ($app) {
            return new UniqueEntityValidator($app['doctrine']);
        });

        $app->register(new SilexFormServiceProvider());

        $app['form.extensions'] = $app->share($app->extend('form.extensions', function ($extensions, $app) {
            $extensions[] = new DoctrineOrmExtension($app['doctrine']);

            return $extensions;
        }));

        $app->register(new DoctrineOrmManagerRegistryProvider());
    }

    public function boot(Application $app)
    {
    }
}
