<?php

namespace SilexMax\Test;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

abstract class OrmTestCase extends \PHPUnit_Framework_TestCase
{
    protected $em;
    protected $schemaTool;
    protected $loader;
    protected $executor;

    abstract public function createTestEntityManager();

    public function setUp()
    {
        $this->em = $this->createTestEntityManager();
        $this->schemaTool = new SchemaTool($this->em);
        $this->loader = new Loader();
        $this->executor = new ORMExecutor($this->em, new ORMPurger());
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
