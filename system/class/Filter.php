<?php

class Filter {
    /**
     * @param $string
     * @return mixed
     */
    static public function clearFullSpecialChars($string): mixed {
        return filter_var(value: $string, filter: FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * @param $string
     * @return string
     */
    static public function output($string): string {
        return self::clearFullSpecialChars(string: $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    static public function clearString($string): mixed {
        return filter_var(value: $string, filter: FILTER_SANITIZE_STRING);
    }

    /**
     * @param $string
     * @return int
     */
    static public function clearInt($string): int {
        return intval(value: abs(num: filter_var(value: $string, filter: FILTER_SANITIZE_NUMBER_INT)));
    }
}