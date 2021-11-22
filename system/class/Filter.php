<?php

class Filter {

    static public function clearFullSpecialChars($string): mixed {
        return filter_var(value: $string, filter: FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    static public function output($string): string {
        return self::clearFullSpecialChars(string: $string);
    }

    static public function clearString($string): mixed {
        return filter_var(value: $string, filter: FILTER_SANITIZE_STRING);
    }

    static public function clearInt($string): int {
        return intval(value: abs(num: filter_var(value: $string, filter: FILTER_SANITIZE_NUMBER_INT)));
    }
}