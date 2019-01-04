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
}