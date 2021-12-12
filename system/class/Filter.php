<?php

use JetBrains\PhpStorm\Pure;

class Filter
{
    /**
     * @param $string
     * @return mixed
     */
    #[Pure] static public function clearFullSpecialChars($string): mixed
    {
        return filter_var(value: $string, filter: FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    /**
     * @param $string
     * @return string
     */
    #[Pure] static public function output($string): string
    {
        return self::clearFullSpecialChars(string: $string);
    }

    /**
     * @param $string
     * @return mixed
     */
    #[Pure] static public function clearString($string): mixed
    {
        return filter_var(value: $string, filter: FILTER_SANITIZE_STRING);
    }

    /**
     * @param $string
     * @return int
     */
    #[Pure] static public function clearInt($string): int
    {
        return intval(value: abs(num: filter_var(value: $string, filter: FILTER_SANITIZE_NUMBER_INT)));
    }
}