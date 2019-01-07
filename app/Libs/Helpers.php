<?php

namespace App\Libs;

abstract class Helpers {

    /**
     * Check string starting with given substring
     */
    public static function startsWith($string, $startString)
    {
        $len = strlen($startString);
    
        return (substr($string, 0, $len) === $startString); 
    }

    /**
     * Check number of digits after decimal point
     */
    public static function numberDecimals($number)
    {
        $exploded = explode(".", $number);

        return strlen($exploded[1]);
    }
}