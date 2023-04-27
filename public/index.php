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
    $uiFilePath = $conf->get('app.prod') ? 'js/dist/app.min.js' : 'js/src/index.js';

    $search = new FindProducts($connection);
    $productsResponse = $search->find();

    $rendering = new RenderPage(VIEWS_PATH);
    $page = new RenderProducts(VIEWS_PATH, $rendering);
    $page->setParams($productsResponse, $uiFilePath)->render();

} catch (Throwable $e) {
    // header("HTTP/1.1 500 Internal Server Error");
    $rendering = new RenderPage(VIEWS_PATH);
    $page = new RenderException(
        VIEWS_PATH,
        $rendering
    );
    $page->setParams($e, (isset($conf)) ? $conf->get('app.debug') : false)->render();
}