<?php

namespace App\Pages;

class RenderPage
{
    private string $viewsDir;
    private string $templatePath;

    private string $title = 'ATON-TEST';
    private string $content = '';

    private string $extraHead = '';
    private string $extraScripts = '';

    public function __construct(string $viewsDir)
    {
        $this->viewsDir = $viewsDir;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function setExtraHead(string $extraHead)
    {
        $this->extraHead = $extraHead;
    }

    public function setExtraScripts(string $extraScripts)
    {
        $this->extraScripts = $extraScripts;
    }

    public function render($context = null)
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