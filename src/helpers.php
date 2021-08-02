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