<?php

namespace App\Test;

use SilexMax\Provider\OrmServiceProvider;
use SilexMax\Test\OrmTestCase as BaseOrmTestCase;

class OrmTestCase extends BaseOrmTestCase
{
    public function createTestEntityManager()
    {
        $app = require __DIR__ . '/../../app.php';

        $app['db.options'] = ['driver' => 'pdo_sqlite', 'memory' => true];

        $app->register(new OrmServiceProvider());

        return $app['orm.em'];
    }
}
