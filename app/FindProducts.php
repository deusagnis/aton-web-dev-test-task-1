<?php

namespace App;

use App\Models\Product;
use Medoo\Medoo;
use MGGFLOW\ExceptionManager\ManageException;

/**
 * Поиск продуктов в БД по переданным GET параметрам.
 */
class FindProducts
{
    /**
     * Доступные значения для количества выборки Продуктов из БД.
     */
    const AVAILABLE_COUNTS = [10, 15, 25];

    /**
     * Минимальный количественный отступ выбора Продуктов из БД.
     */
    const MIN_PRODUCTS_OFFSET = 0;

    /**
     * Максимальная длина подстроки поиска Продуктов.
     */
    const MAX_QUERY_LENGTH = 512;

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
     * @throws \MGGFLOW\ExceptionManager\Interfaces\UniException
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
        $this->searchParams = [
            'offset' => $_GET['offset'] ?? 0,
            'count' => $_GET['count'] ?? self::AVAILABLE_COUNTS[0],
            'sortBy' => $_GET['sortBy'] ?? null,
            'query' => $_GET['q'] ?? null
        ];

        $this->searchParams['offset'] = intval($this->searchParams['offset']);
        $this->searchParams['count'] = intval($this->searchParams['count']);
        if (empty($this->searchParams['query'])) {
            $this->searchParams['query'] = null;
        }
    }

    private function normalizeParams()
    {
        $this->searchParams['query'] = addcslashes($this->searchParams['query'], '\%_');
    }

    private function validateParams()
    {
        if ($this->searchParams['offset'] < self::MIN_PRODUCTS_OFFSET) throw ManageException::build()
            ->log()->warning()->b()
            ->desc()->invalid('Offset Parameter')->b()
            ->fill();

        if (!in_array($this->searchParams['count'], self::AVAILABLE_COUNTS))
            throw ManageException::build()
                ->log()->warning()->b()
                ->desc()->invalid('Count Parameter')
                ->context($this->searchParams)->b()
                ->fill();

        if (($this->searchParams['sortBy'] !== null)) {
            if (!is_array($this->searchParams['sortBy'])
                || count($this->searchParams['sortBy']) > 1
                || !isset($this->searchParams['sortBy']['price'])
            )
                throw ManageException::build()
                    ->log()->warning()->b()
                    ->desc()->invalid('Sorting Parameter')->b()
                    ->fill();
        }


        if ($this->searchParams['query'] !== null
            && strlen($this->searchParams['query']) > self::MAX_QUERY_LENGTH
        ) throw ManageException::build()
            ->log()->warning()->b()
            ->desc()->invalid('Query Parameter')->b()
            ->fill();
    }

    private function countProducts()
    {
        $where = ($this->searchParams['query'] === null)
            ? null
            : ['name[~]' => $this->searchParams['query']];

        $this->productsCount = $this->connection->count(Product::TABLE_NAME, $where);
        if ($this->productsCount === null) throw ManageException::build()
            ->log()->error()->b()
            ->desc()->failed('Products Counting')
            ->context($this->connection->info(), 'info')
            ->internal()->b()
            ->fill();
    }

    private function loadProducts()
    {
        // TODO: Возможно добавление кеширования для снижения нагрузки на БД.
        $where = [
            'LIMIT' => [$this->searchParams['offset'], $this->searchParams['count']]
        ];
        if (($this->searchParams['query'] !== null))
            $where['name[~]'] = $this->searchParams['query'];
        if (($this->searchParams['sortBy'] !== null))
            $where['ORDER'] = [
                'price' => ($this->searchParams['sortBy']['price'] === 'asc') ? 'ASC' : 'DESC'
            ];

        $this->products = $this->connection->select(Product::TABLE_NAME, [
            'id', 'name', 'price', 'created_at'
        ], $where);
        if ($this->products === null) throw ManageException::build()
            ->log()->error()->b()
            ->desc()->failed('Products Loading')
            ->context($this->connection->info(), 'info')
            ->internal()->b()
            ->fill();
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