<?php

use App\Test\OrmTestCase;

class FooTest extends OrmTestCase
{
    public function testPersisting()
    {
        $this->createSchema(['App\Entity\Foo']);

        $foo = new App\Entity\Foo();
        $foo->setName('Test');
        $this->em->persist($foo);
        $this->em->flush();

        $this->em->clear();
        $foo2 = $this->em->find('App\Entity\Foo', 1);

        $this->assertEquals('Test', $foo2->getName());
    }

    public function testValidator()
    {
        $foo = new App\Entity\Foo();
        $errors = $this->validator->validate($foo);

        $this->assertEquals(1, count($errors));
    }
}
