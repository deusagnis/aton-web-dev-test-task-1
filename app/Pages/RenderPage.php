<?php

namespace App\Pages;

/**
 * Модуль отображения страницы на основе главного шаблона (template.php).
 */
class RenderPage
{
    private string $viewsDir;
    private string $templatePath;

    private string $title = 'ATON-TEST';
    private string $content = '';

    private string $extraHead = '';
    private string $extraScripts = '';

    /**
     * Инициализировать модуль отображения страницы.
     * @param string $viewsDir Директория с HTML компонентами.
     */
    public function __construct(string $viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }

    /**
     * Установить заголовок страницы.
     * @param string $title Заголовок страницы.
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * Установть содержимое страницы.
     * @param string $content Содержимое страницы (HTML).
     * @return void
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Установить дополнительное содержание в конец <head>.
     * @param string $extraHead Дополнительное содержание для <head>.
     * @return void
     */
    public function setExtraHead(string $extraHead)
    {
        $this->extraHead = $extraHead;
    }

    /**
     * Установить дополнительные скрипты и/или содержание в конец <body>.
     * @param string $extraScripts Дополнительные скрипты и/или содержание.
     * @return void
     */
    public function setExtraScripts(string $extraScripts)
    {
        $this->extraScripts = $extraScripts;
    }

    /**
     * Отобразить страницу на основе главное шаблона.
     * @param null|object $context Контекст выпаолнения главного шаблона.
     * @return void
     */
    public function render(?object $context = null)
    {
        $this->genTemplatePath();
        echo LoadComponent::load($this->templatePath, $context ?? $this,
            $this->content, $this->title,
            $this->extraHead, $this->extraScripts
        );

    }

    private function genTemplatePath()
    {
        $this->templatePath = $this->viewsDir . DIRECTORY_SEPARATOR . 'template.php';
    }
}