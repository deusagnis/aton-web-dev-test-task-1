<?php

use App\Config\CreateConfig;
use App\Database\CreateConnection;
use App\Env\LoadEnv;
use App\FindProducts;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

try {
    LoadEnv::load(ROOT_DIR);
    $conf = CreateConfig::create(ROOT_DIR . DIRECTORY_SEPARATOR . 'config');
    $connection = CreateConnection::create($conf);

    $search = new FindProducts($connection);
    $products = $search->find();

    echo '<pre>' . json_encode($products) . '</pre>';
    // TODO Render Products Page
} catch (Throwable $e) {
    if (method_exists($e, 'toArray')) {
        echo '<pre>' . json_encode($e->toArray(false)) . '</pre>';
    } else {
        throw $e;
    }
    // TODO Render Exception
}