<?php

/*
 * This file is part of the PHP-JWT package.
 *
 * (c) Jitendra Adhikari <jiten.adhikary@gmail.com>
 *     <https://github.com/adhocore>
 *
 * Licensed under MIT license.
 */

namespace Ahc\Jwt;
if (!defined('APP_INIT')) {
    require_once '../../library/defaultRouting.php';
}

class JWTException extends \InvalidArgumentException
{
    // ;)
}
