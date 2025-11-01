<?php
define('APP_INIT', true);
// $GLOBALS['root'] = "";
// run sql files
require_once 'config/connections.php';
require_once 'library/functions.php';
require_once 'model/accounts-model.php';

use PHPUnit\Framework\TestCase;

class accounts_modelTest extends TestCase
{

    public function setUp()
    {
    }

    public function testgetClient()
    {
        $input="admin@me.com";
        $result = getClient($input);
        $expected = "adminuser";
        $this->assertNotEquals(false, $result);
        $this->assertEquals($expected, $result['displayName']);
    }

    public function testcheckExistingEmailTrue()
    {
        $input="admin@me.com";
        $result = checkExistingEmail($input);
        $expected = 1;
        $this->assertNotEquals(false, $result);
        $this->assertEquals($expected, $result);
    }

    public function testcheckExistingEmailFalse()
    {
        $input="admin2@me.com";
        $result = checkExistingEmail($input);
        $expected = 0;
        $this->assertEquals($expected, $result);
    }
}
