<?php

namespace App\Pages;

/**
 * Класс родитель для отображения страниц приложения.
 */
abstract class RenderingPage
{
    protected string $viewsDir;
    protected RenderPage $rendering;

    /**
     * Инициализация
     * @param string $viewsPath Путь к директории с HTML компонентами.
     * @param RenderPage $rendering Модуль отображения страницы.
     */
    public function __construct(string $viewsPath, RenderPage $rendering)
    {
        $this->viewsDir = $viewsPath;
        $this->rendering = $rendering;
    }

    /**
     * Показать страницу пользователю.
     * @return mixed
     */
    abstract public function render();
}