<?php

use SilexMax\Twig\ClassFilter;

class ClassFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterColsReturnsClasesWithColsPrefix()
    {
        $result = ClassFilter::filterCols(['col-md-1'], ['col-md-2']);
        $this->assertEquals(0, count($result));

        $result = ClassFilter::filterCols(['col-md-offset-1'], ['col-md-offset-2']);
        $this->assertEquals(0, count($result));

        $result = ClassFilter::filterCols(['col-md-offset-1'], ['col-lg-offset-2']);
        $this->assertEquals(1, count($result));
        $this->assertEquals('col-lg-offset-2', $result[0]);

        $result = ClassFilter::filterCols(['col-md-1'], ['col-md-offset-2']);
        $this->assertEquals(1, count($result));
        $this->assertEquals('col-md-offset-2', $result[0]);

        $result = ClassFilter::filterCols(['other', 'col-md-1'], ['test', 'col-md-offset-2']);
        $this->assertEquals(2, count($result));
        $this->assertEquals('test', $result[0]);
        $this->assertEquals('col-md-offset-2', $result[1]);
    }

    public function testAddingClasses()
    {
        $class = ClassFilter::classDefault('', 'test');
        $this->assertEquals('test', $class);

        $class = ClassFilter::classDefault('class1', 'col-md-3');
        $this->assertEquals('class1 col-md-3', $class);

        $class = ClassFilter::classDefault('class1 col-md-2', 'col-md-3');
        $this->assertEquals('class1 col-md-2', $class);

        $class = ClassFilter::classDefault('class1 col-md-2', 'col-md-offset-3');
        $this->assertEquals('class1 col-md-2 col-md-offset-3', $class);
    }
}
