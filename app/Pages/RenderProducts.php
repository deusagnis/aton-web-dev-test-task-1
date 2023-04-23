<?php

namespace App\Pages;

class RenderProducts extends RenderingPage
{
    private array $products;

    public function setParams(array $products): self
    {
        $this->products = $products;

        return $this;
    }

    public function render()
    {
        $this->rendering->setTitle('Aton Products');
        $this->rendering->setExtraScripts($this->createProductsJs() . $this->createAppJs());
        $this->rendering->setContent(LoadComponent::load(
            $this->viewsPath . DIRECTORY_SEPARATOR . 'products.php',
            $this, $this->products
        ));
        $this->rendering->render();
    }

    private function createProductsJs(): string
    {
        return '<script>
                    const FOUND_PRODUCTS = \'' . json_encode($this->products) . '\'
                </script>';
    }

    private function createAppJs(): string
    {
        return '<script src="js/index.js"></script>';
    }
}