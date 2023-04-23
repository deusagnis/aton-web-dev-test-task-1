<?php

namespace App\Pages;

use Closure;

class LoadComponent
{
    public static function load($path, $context, ...$args): ?string
    {
        if (is_file($path)) {
            ob_start();
            Closure::fromCallable(include $path)->call($context, ...$args);
            return ob_get_clean();
        }
        return null;
    }
}