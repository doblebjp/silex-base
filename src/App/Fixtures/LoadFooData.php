<?php

namespace App\Fixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use App\Entity\Foo;

class LoadFooData extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $foo = new Foo();
            $foo->setName("Foo $i");

            $manager->persist($foo);
            $manager->flush();

            $this->addReference("foo$i", $foo);
        }

    }
}
