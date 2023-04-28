<?php

use App\RequestHandling\ParseProductsSearchParams;
use PHPUnit\Framework\TestCase;

class ParseProductsSearchParamsTest extends TestCase
{
    protected function setUp(): void
    {
        $_GET['count'] = 10;
        $_GET['offset'] = 1;
        $_GET['sortBy'] = ['price' => 'asc'];
        $_GET['q'] = 'prod';
    }

    /**
     * Проверка определения параметров поиска продуктов.
     * @return void
     */
    public function testParse()
    {
        $searchParams = ParseProductsSearchParams::parse(10);
        self::assertEquals(10, $searchParams['count']);
        self::assertEquals(1, $searchParams['offset']);
        self::assertEquals(['price' => 'asc'], $searchParams['sortBy']);
        self::assertEquals('prod', $searchParams['query']);
    }
}