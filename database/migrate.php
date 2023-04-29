<?php

use App\Config\CreateConfig;
use App\Database\CreateConnection;
use App\Env\LoadEnv;
use App\Models\Product;
use MGGFLOW\ExceptionManager\ManageException;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * Создать таблицу продуктов в БД, если она отсутствует.
 */
try {
    LoadEnv::load(ROOT_DIR);
    $conf = CreateConfig::create(ROOT_DIR . DIRECTORY_SEPARATOR . 'config');
    $connection = CreateConnection::create($conf);

    $creation = $connection->create(Product::TABLE_NAME, [
        'id' => [
            'INT',
            'UNSIGNED',
            'NOT NULL',
            'AUTO_INCREMENT',
            'PRIMARY KEY'
        ],
        'name' => [
            'VARCHAR(512)',
            'NOT NULL',
        ],
        'price' => [
            'DECIMAL(19,4)',
            'UNSIGNED',
            'NOT NULL',
        ],
        'created_at' => [
            'INT',
            'UNSIGNED',
            'NOT NULL',
        ],
    ]);

    if ($creation === null) throw ManageException::build()
        ->log()->error()->b()
        ->desc()->failed('Products Table Creation')
        ->context($connection->info(), 'info')
        ->context($connection->last(), 'query')->b()
        ->fill();

    echo 'Successful Database Migration' . PHP_EOL;
} catch (Throwable $e) {
    if (method_exists($e, 'toArray')) {
        echo '<pre>' . json_encode($e->toArray(false)) . '</pre>';
    } else {
        throw $e;
    }
}