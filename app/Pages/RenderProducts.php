<?php

namespace App\Pages;

/**
 * Отобразить страницу Продуктов (Товаров).
 */
class RenderProducts extends RenderingPage
{
    private array $productsResponse;

    /**
     * Установить параметры страницы.
     * @param array $productsResponse Массив ответа полученных продуктов из БД.
     * @return $this
     */
    public function setParams(array $productsResponse): self
    {
        $this->productsResponse = $productsResponse;

        return $this;
    }

    /**
     * Отобразить страницу продуктов.
     * @return void
     */
    public function render()
    {
        $this->rendering->setTitle('Aton Products');
        $this->rendering->setExtraScripts($this->createProductsJs() . $this->createAppJs());
        $this->rendering->setContent(LoadComponent::load(
            $this->viewsDir . DIRECTORY_SEPARATOR . 'products.php',
            $this, $this->productsResponse['count'],
            $this->productsResponse['search']['offset'],
            $this->productsResponse['search']['count'],
            $this->productsResponse['search']['query'],
            $this->productsResponse['search']['sortBy'],
        ));
        $this->rendering->render();
    }

    private function createProductsJs(): string
    {
        return '<script>
                    const FOUND_PRODUCTS_JSON = \'' . json_encode($this->productsResponse) . '\'
                </script>';
    }

    private function createAppJs(): string
    {
        return '<script type="module" src="js/index.js"></script>';
    }
}