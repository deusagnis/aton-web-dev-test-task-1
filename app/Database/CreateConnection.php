<?php

namespace App\Database;

use League\Config\Configuration;
use Medoo\Medoo;

/**
 * Создание подключения к базе данных с помощью библиотеки Medoo.
 */
class CreateConnection
{
    /**
     * Создать экземпляр фасада работы с БД на основе конфигурации.
     * @param Configuration $config Экземпляр конфигурации приложения.
     * @return Medoo Фасад работы с БД.
     */
    public static function create(Configuration $config): Medoo
    {
        return new Medoo([
            'type' => $config->get('database.type'),
            'host' => $config->get('database.host'),
            'database' => $config->get('database.database'),
            'username' => $config->get('database.username'),
            'password' => $config->get('database.password'),

            'logging' => $config->get('app.debug'),
        ]);
    }
}