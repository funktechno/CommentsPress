<?php
// run sql files
require_once 'config/connections.php';
require_once 'library/functions.php';
require_once 'model/configuration-model.php';

// use drmonkeyninja\Average;
use PHPUnit\Framework\TestCase;

class configuration_modelTest extends TestCase
{

    public function setUp()
    {
    }

    public function testgetContactFormEmails()
    {
        $result = getContactFormEmails();
        $expected = "admin@me.com,test@me.com";
        $this->assertNotEquals(false, $result);
        $this->assertEquals($expected, $result['data']);
    }

    public function testgetConfigDataManualPages()
    {
        $result = getConfigData("manualPages");
        $expected = "false";
        $this->assertNotEquals(false, $result);
        $this->assertEquals($expected, $result['data']);
    }

    public function testgetConfigDataUnknown()
    {
        $result = getConfigData("unknown");
        $expected = false;
        $this->assertEquals($expected, $result);
    }

    public function testgetConfig()
    {
        $result = getConfig();
        $this->assertEquals(5, count($result));
    }
}
