<?php

namespace App\Models;

use Medoo\Medoo;
use MGGFLOW\ExceptionManager\ManageException;

/**
 * Описание модели Продукта.
 */
class Product extends BaseModel
{
    /**
     * Название таблицы Продуктов в БД.
     */
    const TABLE_NAME = 'products';

    /**
     * Максимальная длина подстроки поиска Продуктов.
     */
    const MAX_NAME_LENGTH = 512;

    /**
     * Найти продукты по заданным параметрам.
     * @param Medoo $connection Экземпляр соеденинения с БД.
     * @param array $searchParams Параметры поиска.
     * @return array Массив продуктов.
     * @throws \MGGFLOW\ExceptionManager\Interfaces\UniException
     */
    static public function find(Medoo $connection, array $searchParams): array
    {
        $where = [
            'LIMIT' => [$searchParams['offset'], $searchParams['count']]
        ];
        if (($searchParams['query'] !== null))
            $where['name[~]'] = $searchParams['query'];
        if (($searchParams['sortBy'] !== null))
            $where['ORDER'] = [
                'price' => ($searchParams['sortBy']['price'] === 'asc') ? 'ASC' : 'DESC'
            ];

        $products = $connection->select(self::TABLE_NAME, [
            'id', 'name', 'price', 'created_at'
        ], $where);
        if ($products === null) throw ManageException::build()
            ->log()->error()->b()
            ->desc()->failed('Products Loading')
            ->context($connection->info(), 'info')
            ->internal()->b()
            ->fill();

        return $products;
    }

    /**
     * Посчитать количество продуктов по заданным параметрам.
     * @param Medoo $connection Экземпляр соеденинения с БД.
     * @param array $searchParams Параметры поиска.
     * @return int Число продуктов.
     * @throws \MGGFLOW\ExceptionManager\Interfaces\UniException
     */
    static public function count(Medoo $connection, array $searchParams): int
    {
        $where = ($searchParams['query'] === null)
            ? null
            : ['name[~]' => $searchParams['query']];

        $productsCount = $connection->count(self::TABLE_NAME, $where);
        if ($productsCount === null) throw ManageException::build()
            ->log()->error()->b()
            ->desc()->failed('Products Counting')
            ->context($connection->info(), 'info')
            ->internal()->b()
            ->fill();

        return $productsCount;
    }
}