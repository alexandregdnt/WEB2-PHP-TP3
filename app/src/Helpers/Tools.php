<?php

namespace App\Helpers;

class Tools {
    public static function redirect($page): void
    {
        header('Location: ' .$page);
        die();
    }

    public static function capitalize(string $string): string
    {
        if (str_contains($string, '-')) {
            $string = strtolower($string);
            $strArray = explode('-', $string);
            $strArray = array_map(fn($str) => ucfirst($str), $strArray);
            return implode('-', $strArray);
        }
        return ucfirst($string);
    }

// Other functions
    public static function getClientIP() {
        return filter_input(INPUT_SERVER,'REMOTE_ADDR');
    }

}