<?php

if (!function_exists('toBangla')) {
    /**
     * Convert English digits to Bangla digits.
     *
     * @param string|int|null $number
     * @return string
     */
    function toBangla($number)
    {
        if ($number === null) {
            return '';
        }

        $search = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $replace = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];

        return str_replace($search, $replace, (string) $number);
    }
}
