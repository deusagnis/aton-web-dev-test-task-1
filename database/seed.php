<?php

use App\Config\CreateConfig;
use App\Database\CreateConnection;
use App\Env\LoadEnv;
use App\Models\Product;
use MGGFLOW\ExceptionManager\ManageException;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * Минимальное количество продуктов.
 */
const MIN_PRODUCTS_COUNT = 50;

/**
 * Заполнить таблицу случайными тестовыми данными.
 */
try {
    LoadEnv::load(ROOT_DIR);
    $conf = CreateConfig::create(ROOT_DIR . DIRECTORY_SEPARATOR . 'config');
    $connection = CreateConnection::create($conf);

    $counter = $connection->count(Product::TABLE_NAME);

    if ($counter === null) throw ManageException::build()
        ->log()->error()->b()
        ->desc()->failed('Products Counting')
        ->context($connection->info(), 'info')
        ->context($connection->last(), 'query')->b()
        ->fill();

    if ($counter >= MIN_PRODUCTS_COUNT) return;

    $products = [];
    for ($i = 0; $i < MIN_PRODUCTS_COUNT; $i++) {
        $products[] = [
            'name' => uniqid('Product_'),
            'price' => rand(10000, 100000) / 100,
            'created_at' => time() + rand(0, 5)
        ];
    }

    $inserting = $connection->insert(Product::TABLE_NAME, $products);
    if ($inserting === null) throw ManageException::build()
        ->log()->error()->b()
        ->desc()->failed('Products Inserting')
        ->context($connection->info(), 'info')
        ->context($connection->last(), 'query')->b()
        ->fill();

    echo 'Successful Database Seeding';
} catch (Throwable $e) {
    if (method_exists($e, 'toArray')) {
        echo '<pre>' . json_encode($e->toArray(false)) . '</pre>';
    } else {
        throw $e;
    }
}