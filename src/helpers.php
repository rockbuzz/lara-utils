<?php

use Rockbuzz\LaraUtils\Logging;

if (!function_exists('logging')) {
    /**
     * @param string|Throwable $logable
     * @param array $context
     * @return Logging
     */
    function logging($logable, array $context = []): Logging
    {
        return new Logging($logable, $context);
    }
}

if (!function_exists('percentage_of')) {
    function percentage_of(int $percentage, float $float): float
    {
        return $float * ($percentage / 100);
    }
}

if (!function_exists('format_currency')) {
    function format_currency(int $cents): float
    {
        return (float)number_format($cents / 100, 2, '.', '');
    }
}

if (!function_exists('to_pennies')) {
    function to_pennies(float $float): int
    {
        return (int)$float * 100;
    }
}
