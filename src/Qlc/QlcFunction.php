<?php

namespace Scheb\QlcGenerator\Qlc;

class QLCFunction {

    public static $functionId = FIRST_FUNCTION_ID;

    public static function nextId()
    {
        return self::$functionId++;
    }
}
