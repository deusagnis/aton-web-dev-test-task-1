<?php

namespace App\Env;

use Symfony\Component\Dotenv\Dotenv;

/**
 * Загрузка переменных окружения с помощью библиотеки Dotenv.
 */
class LoadEnv
{
    /**
     * Загрузить переменные среды из файла .env.
     * @param string $envDir Путь к директории с файлом окружения.
     * @return void
     */
    public static function load(string $envDir)
    {
        $dotenv = new Dotenv();
        $dotenv->load($envDir . DIRECTORY_SEPARATOR . '.env');
    }
}