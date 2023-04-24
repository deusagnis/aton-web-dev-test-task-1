<?php

namespace App\Pages;

use Throwable;

/**
 * Отображает страницу со случившемся исключением.
 */
class RenderException extends RenderingPage
{
    private Throwable $throwable;
    private bool $debug;

    /**
     * Установить параметры страницы.
     * @param Throwable $throwable Отображаемое исключение.
     * @param bool $debug Флаг режима отладки.
     * @return $this
     */
    public function setParams(Throwable $throwable, bool $debug): self
    {
        $this->throwable = $throwable;
        $this->debug = $debug;

        return $this;
    }

    /**
     * Отобразить пользователю страницу с ошибкой.
     * @return void
     */
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
            $this->viewsDir . DIRECTORY_SEPARATOR . 'exception.php',
            $this,
            $this->throwable,
            $this->debug
        ));
    }
}