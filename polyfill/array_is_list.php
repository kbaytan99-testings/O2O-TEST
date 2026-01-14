<?php

/**
 * Polyfill for array_is_list() function (PHP 8.1+)
 * Required for PHP 8.0 compatibility with Symfony 5.4
 */

if (!function_exists('array_is_list')) {
    /**
     * Checks whether a given array is a list
     *
     * @param array $array The array to check
     * @return bool Returns true if array is a list, false otherwise
     */
    function array_is_list(array $array): bool
    {
        if ($array === []) {
            return true;
        }

        $current_key = 0;

        foreach ($array as $key => $noop) {
            if ($key !== $current_key) {
                return false;
            }

            ++$current_key;
        }

        return true;
    }
}
