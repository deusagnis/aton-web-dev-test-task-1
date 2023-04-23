<?php

namespace App\Pages;

abstract class RenderingPage
{
    protected string $viewsPath;
    protected RenderPage $rendering;

    public function __construct(string $viewsPath, RenderPage $rendering)
    {
        $this->viewsPath = $viewsPath;
        $this->rendering = $rendering;
    }

    abstract public function render();
}