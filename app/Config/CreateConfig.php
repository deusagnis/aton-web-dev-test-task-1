<?php

namespace App\Config;

use League\Config\Configuration;
use Nette\Schema\Expect;

class CreateConfig
{
    public static function create(string $configDir): Configuration
    {
        $conf = new Configuration([
            'app' => Expect::structure([
                'debug' => Expect::bool()->default(false),
            ]),
            'database' => Expect::structure([
                'type' => Expect::anyOf('mysql', 'postgresql')->required(),
                'host' => Expect::string()->default('localhost'),
                'database' => Expect::string()->required(),
                'username' => Expect::string()->required(),
                'password' => Expect::string()->nullable(),
            ]),
        ]);

        $conf->merge(['app' => include $configDir . DIRECTORY_SEPARATOR . 'app.php']);
        $conf->merge(['database' => include $configDir . DIRECTORY_SEPARATOR . 'database.php']);

        return $conf;
    }
}