<?php

namespace App\Routes;

use League\Config\Configuration;

/**
 * Определение пути для файла клиентской части приложения.
 */
class ResolveUIFile
{
    /**
     * Определить путь для подключения файла клиентского приложения.
     * @param Configuration $conf Экземпляр конфигурации приложения.
     * @return string
     */
    public static function resolve(Configuration $conf): string
    {
        $path = $conf->get('app.prod') ? '/js/dist/app.min.js' : '/js/src/index.js';
        $path = '/' . trim($conf->get('app.publicPrefix'), '/') . $path;
        return $path . '?hk=' . md5($conf->get('app.uiKey'));
    }
}