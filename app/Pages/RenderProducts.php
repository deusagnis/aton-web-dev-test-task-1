<?php

namespace App\Pages;

class RenderProducts extends RenderingPage
{
    private array $productsResponse;

    public function setParams(array $productsResponse): self
    {
        $this->productsResponse = $productsResponse;

        return $this;
    }

    public function render()
    {
        $this->rendering->setTitle('Aton Products');
        $this->rendering->setExtraScripts($this->createProductsJs() . $this->createAppJs());
        $this->rendering->setContent(LoadComponent::load(
            $this->viewsPath . DIRECTORY_SEPARATOR . 'products.php',
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