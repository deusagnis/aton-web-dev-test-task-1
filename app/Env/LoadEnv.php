<?php

namespace App\Env;

use Symfony\Component\Dotenv\Dotenv;

class LoadEnv
{
    public static function load(string $envDir)
    {
        $dotenv = new Dotenv();
        $dotenv->load($envDir . DIRECTORY_SEPARATOR . '.env');
    }
}