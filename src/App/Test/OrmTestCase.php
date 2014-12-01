<?php

namespace App\Test;

use SilexBase\Test\OrmTestCase as BaseOrmTestCase;
use SilexBase\Setup;
use Silex\Application;

class OrmTestCase extends BaseOrmTestCase
{
    public function configure(Application $app)
    {
        Setup::loadConfig($app, __DIR__ . '/../../../config', [
            'root_dir' => realpath(__DIR__ . '/../../..')
        ]);

        $app['debug'] = true;
        $app['db.options'] = ['driver' => 'pdo_sqlite', 'memory' => true];
    }
}
