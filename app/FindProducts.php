<?php

namespace App;

use App\Models\Product;
use App\RequestHandling\ParseProductsSearchParams;
use App\Validation\ValidateProductsSearchParams;
use Medoo\Medoo;
use MGGFLOW\ExceptionManager\Interfaces\UniException;

/**
 * Поиск продуктов в БД по переданным GET параметрам.
 */
class FindProducts
{
    /**
     * Доступные значения для количества выборки Продуктов из БД.
     */
    const AVAILABLE_COUNTS = [10, 15, 25];

    private Medoo $connection;
    private array $searchParams;

    private ?int $productsCount;
    private ?array $products;

    /**
     * Инициализировать поиск.
     * @param Medoo $connection Экземпляр фасада соединения с БД.
     */
    public function __construct(Medoo $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Найти Продукты в БД.
     * @return array Массив результата поиска [count: всего найдено, items: продукты, search: параметры поиска]
     * @throws UniException
     */
    public function find(): array
    {
        $this->parseParams();
        $this->validateParams();
        $this->normalizeParams();
        $this->countProducts();
        $this->loadProducts();

        return $this->createResult();
    }

    private function parseParams()
    {
        $this->searchParams = ParseProductsSearchParams::parse(self::AVAILABLE_COUNTS[0]);
    }

    private function normalizeParams()
    {
        $this->searchParams['query'] = addcslashes($this->searchParams['query'], '\%_');
    }

    /**
     * @throws UniException
     */
    private function validateParams()
    {
        ValidateProductsSearchParams::validate($this->searchParams, self::AVAILABLE_COUNTS);
    }

    /**
     * @throws UniException
     */
    private function countProducts()
    {
        $this->productsCount = Product::count($this->connection, $this->searchParams);
    }

    /**
     * @throws UniException
     */
    private function loadProducts()
    {
        // TODO: Возможно добавление кеширования для снижения количества запросов к БД.
        $this->products = Product::find($this->connection, $this->searchParams);
    }

    private function createResult(): array
    {
        return [
            'count' => $this->productsCount,
            'items' => $this->products,
            'search' => $this->searchParams
        ];
    }
}