<?php

namespace App\Test;

use SilexBase\Provider\OrmServiceProvider;
use SilexBase\Test\OrmTestCase as BaseOrmTestCase;
use SilexBase\Setup;

class OrmTestCase extends BaseOrmTestCase
{
    public function createTestEntityManager()
    {
        $app = Setup::createApplication();

        $app->register(new OrmServiceProvider());

        Setup::loadConfig($app, __DIR__ . '/../../../config', [
            'root_dir' => realpath(__DIR__ . '/../../..')
        ]);

        $app['debug'] = true;
        $app['db.options'] = ['driver' => 'pdo_sqlite', 'memory' => true];

        return $app['orm.em'];
    }
}
