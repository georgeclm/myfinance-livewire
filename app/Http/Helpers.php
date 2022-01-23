<?php

if (!function_exists('convert_to_number')) {
    function convert_to_number($string)
    {
        return preg_replace('/[^0-9]/', '', $string);
        // return str_replace('.', '', substr($string, 4));
    }
}
