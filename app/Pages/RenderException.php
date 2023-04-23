<?php

namespace App\Pages;

use Throwable;

class RenderException extends RenderingPage
{
    private Throwable $throwable;
    private bool $debug;

    public function setParams(Throwable $throwable, bool $debug): self
    {
        $this->throwable = $throwable;
        $this->debug = $debug;

        return $this;
    }

    public function render()
    {
        $this->setTitle();
        $this->setContent();

        $this->rendering->render();
    }

    private function setTitle()
    {
        $this->rendering->setTitle('Something went wrong...');
    }

    private function setContent()
    {
        $this->rendering->setContent(LoadComponent::load(
            $this->viewsPath . DIRECTORY_SEPARATOR . 'exception.php',
            $this,
            $this->throwable,
            $this->debug
        ));
    }
}