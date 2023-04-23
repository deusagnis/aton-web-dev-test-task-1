<?php

use App\Config\CreateConfig;
use App\Database\CreateConnection;
use App\Env\LoadEnv;
use App\FindProducts;
use App\Pages\RenderException;
use App\Pages\RenderPage;
use App\Pages\RenderProducts;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

const VIEWS_PATH = ROOT_DIR . DIRECTORY_SEPARATOR . 'views';

try {
    LoadEnv::load(ROOT_DIR);
    $conf = CreateConfig::create(ROOT_DIR . DIRECTORY_SEPARATOR . 'config');
    $connection = CreateConnection::create($conf);

    $search = new FindProducts($connection);
    $products = $search->find();

    $rendering = new RenderPage(VIEWS_PATH);
    $page = new RenderProducts(VIEWS_PATH, $rendering);
    $page->setParams($products)->render();

} catch (Throwable $e) {
    $rendering = new RenderPage(VIEWS_PATH);
    $page = new RenderException(
        VIEWS_PATH,
        $rendering
    );
    $page->setParams($e, (isset($conf)) ? $conf->get('app.debug') : false)->render();
}