<?php

namespace App\RequestHandling;

/**
 * Определение параметров поиска продуктов по данным GET запроса.
 */
class ParseProductsSearchParams
{
    /**
     * Определить параметры поиска продуктов на основе данных GET запроса.
     * @param int $defaultCount Количество продуктов для поиска по умолчанию.
     * @return array Массив параметров: offset, count, sortBy, query.
     */
    public static function parse(int $defaultCount)
    {
        $searchParams = [
            'offset' => $_GET['offset'] ?? 0,
            'count' => $_GET['count'] ?? $defaultCount,
            'sortBy' => $_GET['sortBy'] ?? null,
            'query' => $_GET['q'] ?? null
        ];

        $searchParams['offset'] = intval($searchParams['offset']);
        $searchParams['count'] = intval($searchParams['count']);
        if (empty($searchParams['query'])) {
            $searchParams['query'] = null;
        }

        return $searchParams;
    }
}