<?php

namespace SilexBase\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Silex\Provider\DoctrineServiceProvider as DbalServiceProvider;
use Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

class OrmServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app->register(new DbalServiceProvider());
        $app->register(new DoctrineOrmServiceProvider());
    }

    public function boot(Application $app)
    {
    }
}
