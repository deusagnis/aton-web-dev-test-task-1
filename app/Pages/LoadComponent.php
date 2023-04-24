<?php

namespace App\Pages;

use Closure;

/**
 * Загрузчик HTML компонентов из анонимных функций.
 *
 * Принцип работы:
 * Подключает указанный файл компонента, создает из анонимной функции Closure,
 * затем, буферизуя вывод, выполняет Closure, передавая в неё контекст и аргументы.
 * Возвращает полученный вывод в виде строки.
 */
class LoadComponent
{
    /**
     * Загрузить HTML компонент.
     * @param string $path Путь к компоненту.
     * @param object $context Контекст выполнения компонента.
     * @param mixed ...$args Аргументы функции компонента.
     * @return string|null Результирующая строка, либо null, если файл отсутствует.
     */
    public static function load(string $path, object $context, ...$args): ?string
    {
        if (is_file($path)) {
            ob_start();
            Closure::fromCallable(include $path)->call($context, ...$args);
            return ob_get_clean();
        }
        return null;
    }
}