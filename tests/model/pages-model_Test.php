<?php
// run sql files
require_once 'config/connections.php';
require_once 'library/functions.php';
require_once 'model/pages-model.php';

use PHPUnit\Framework\TestCase;

class pages_modelTest extends TestCase
{
    // protected $Average;

    public function setUp()
    {
        // $this->Average = new Average();
    }

    public function testgetPages()
    {
        $result = getPages();
        // $expected = array();
        // $this->assertEquals($expected, $comments);
        $this->assertEquals(1, count($result));
    }
}
