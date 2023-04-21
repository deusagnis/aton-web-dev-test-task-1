<?php

namespace App\Database;

use League\Config\Configuration;
use Medoo\Medoo;

class CreateConnection
{
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