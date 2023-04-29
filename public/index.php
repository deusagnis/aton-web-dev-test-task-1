<?php

use App\Config\CreateConfig;
use App\Database\CreateConnection;
use App\Env\LoadEnv;
use App\FindProducts;
use App\Pages\RenderException;
use App\Pages\RenderPage;
use App\Pages\RenderProducts;
use App\Routes\ResolveUIFile;
use MGGFLOW\ExceptionManager\Interfaces\UniException;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

const VIEWS_PATH = ROOT_DIR . DIRECTORY_SEPARATOR . 'views';

try {
    LoadEnv::load(ROOT_DIR);
    $conf = CreateConfig::create(ROOT_DIR . DIRECTORY_SEPARATOR . 'config');
    $connection = CreateConnection::create($conf);
    $uiFilePath = ResolveUIFile::resolve($conf);

    $search = new FindProducts($connection);
    $productsResponse = $search->find();

    $rendering = new RenderPage(VIEWS_PATH);
    $page = new RenderProducts(VIEWS_PATH, $rendering);
    $page->setParams($productsResponse, $uiFilePath)->render();
} catch (UniException $uniException) {
    $rendering = new RenderPage(VIEWS_PATH);
    $page = new RenderException(
        VIEWS_PATH,
        $rendering
    );
    $page->setParams($uniException, (isset($conf)) ? $conf->get('app.debug') : false)->render();
} catch (Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");
}