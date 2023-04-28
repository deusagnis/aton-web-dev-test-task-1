<?php

namespace App\Validation;

use App\Models\Product;
use MGGFLOW\ExceptionManager\Interfaces\UniException;
use MGGFLOW\ExceptionManager\ManageException;

/**
 * Валидация параметров поиска продуктов.
 */
class ValidateProductsSearchParams
{
    /**
     * Минимальный количественный отступ выбора Продуктов из БД.
     */
    const MIN_PRODUCTS_OFFSET = 0;

    /**
     * Валидировать параметры поиска продуктов.
     * @param array $searchParams Параметры поиска.
     * @param array $availableCounts Доступные значения количества продуктов в запросе.
     * @return void
     * @throws UniException
     */
    public static function validate(array $searchParams, array $availableCounts)
    {
        if ($searchParams['offset'] < self::MIN_PRODUCTS_OFFSET) throw ManageException::build()
            ->log()->warning()->b()
            ->desc()->invalid('Offset Parameter')->b()
            ->fill();

        if (!in_array($searchParams['count'], $availableCounts))
            throw ManageException::build()
                ->log()->warning()->b()
                ->desc()->invalid('Count Parameter')
                ->context($searchParams)->b()
                ->fill();

        if (($searchParams['sortBy'] !== null)) {
            if (!is_array($searchParams['sortBy'])
                || count($searchParams['sortBy']) > 1
                || !isset($searchParams['sortBy']['price'])
            )
                throw ManageException::build()
                    ->log()->warning()->b()
                    ->desc()->invalid('Sorting Parameter')->b()
                    ->fill();
        }

        if ($searchParams['query'] !== null
            && strlen($searchParams['query']) > Product::MAX_NAME_LENGTH
        ) throw ManageException::build()
            ->log()->warning()->b()
            ->desc()->invalid('Query Parameter')->b()
            ->fill();
    }
}