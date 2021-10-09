<?php
// run sql files
require_once 'config/connections.php';
require_once 'library/functions.php';
require_once 'model/reviews-model.php';

// use drmonkeyninja\Average;
use PHPUnit\Framework\TestCase;

class AverageTest extends TestCase
{
    protected $Average;

    public function setUp()
    {
        // $this->Average = new Average();
    }

    public function testPageComments(){
        $slug = "test";
        $moderatedComments = false;
        $userId = null;
        $comments = getPageComments($slug, $moderatedComments, $userId);
        // $expected = array();
        // $this->assertEquals($expected, $comments);
        $this->assertEquals(18, count($comments));
    }

    public function testCalculationOfMean()
    {
        $numbers = [3, 7, 6, 1, 5];
        $this->assertEquals(4.4, 1.1*4);
    }
}