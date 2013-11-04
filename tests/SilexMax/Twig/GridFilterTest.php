<?php

use SilexMax\Twig\GridFilter;

class GridFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testAddingClasses()
    {
        $class = GridFilter::getClass('', 'test');
        $this->assertEquals('test', $class);

        $class = GridFilter::getClass('class1', 'col-md-3');
        $this->assertEquals('class1 col-md-3', $class);

        $class = GridFilter::getClass('class1 col-md-2', 'col-md-3');
        $this->assertEquals('class1 col-md-2', $class);

        $class = GridFilter::getClass('class1 col-md-2', 'col-md-offset-3');
        $this->assertEquals('class1 col-md-2 col-md-offset-3', $class);
    }
}
