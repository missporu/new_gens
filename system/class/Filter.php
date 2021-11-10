<?php
class Filter {
    function clearFullSpecialChars ($string) {
        $string = filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        return $string;
    }

    function output ($string) {
        $string = $this->clearFullSpecialChars($string);
        $string = nl2br($string);
        return $string;
    }

    function clearString ($string) {
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }

    function clearInt ($string) {
        $string = filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        $string = intval(abs($string));
        return $string;
    }
}