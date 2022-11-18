<?php

namespace App\Helpers;

class Filters {
// Get functions
    public static function getString($sN): string
    {
        $str = filter_input(INPUT_GET, $sN, FILTER_UNSAFE_RAW, FILTER_NULL_ON_FAILURE|FILTER_FLAG_NO_ENCODE_QUOTES);
        return self::filter_string_polyfill($str);
    }

    public static function get($sN) {
        return filter_input(INPUT_GET, $sN,FILTER_DEFAULT, FILTER_NULL_ON_FAILURE|FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    public static function getFloat($sN) {
        return filter_input(INPUT_GET, $sN,FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }

    public static function getInt($sN) {
        return filter_input(INPUT_GET, $sN,FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }

    public static function getArray($sN) {
        return filter_input(INPUT_GET, $sN, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    }

// Post functions
    public static function postString($sN): string
    {
        $str = filter_input(INPUT_POST, $sN, FILTER_UNSAFE_RAW, FILTER_NULL_ON_FAILURE|FILTER_FLAG_NO_ENCODE_QUOTES);
        return self::filter_string_polyfill($str);
    }

    public static function post($sN) {
        return filter_input(INPUT_POST, $sN,FILTER_DEFAULT,FILTER_NULL_ON_FAILURE|FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    public static function postInt($sN) {
        return filter_input(INPUT_POST, $sN,FILTER_VALIDATE_INT,FILTER_NULL_ON_FAILURE);
    }

    public static function postFloat($sN) {
        return filter_input(INPUT_POST, $sN,FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
    }

    public static function postArray($sN) {
        return filter_input(INPUT_POST, $sN, FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    }

//    Other Methods
    public static function filter_string_polyfill(string $string): string
    {
        $str = preg_replace('/\x00|<[^>]*>?/', '', $string);
        return str_replace(["'", '"'], ['&#39;', '&#34;'], $str);
    }
}