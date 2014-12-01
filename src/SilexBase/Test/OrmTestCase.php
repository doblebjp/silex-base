<?php

namespace SilexBase\Test;

use Silex\Application;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use SilexBase\Setup;
use SilexBase\Provider\OrmServiceProvider;
use SilexBase\Provider\FormServiceProvider;

abstract class OrmTestCase extends \PHPUnit_Framework_TestCase
{
    protected $em;
    protected $schemaTool;
    protected $loader;
    protected $executor;
    protected $validator;

    abstract public function configure(Application $app);

    public function setUp()
    {
        $app = Setup::createApplication();
        $app->register(new OrmServiceProvider());
        $app->register(new FormServiceProvider());

        $this->configure($app);

        $this->em = $app['orm.em'];
        $this->schemaTool = new SchemaTool($this->em);
        $this->loader = new Loader();
        $this->executor = new ORMExecutor($this->em, new ORMPurger());

        $this->validator = $app['validator'];
    }

    public function createSchema(array $classNames)
    {
        $classes = [];

        foreach ($classNames as $className) {
            $classes[] = $this->em->getClassMetadata($className);
        }

        $this->schemaTool->createSchema($classes);
    }
}
