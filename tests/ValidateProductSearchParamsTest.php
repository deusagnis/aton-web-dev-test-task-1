<?php

use App\Models\Product;
use App\Validation\ValidateProductsSearchParams;
use MGGFLOW\ExceptionManager\Interfaces\UniException;
use PHPUnit\Framework\TestCase;

class ValidateProductSearchParamsTest extends TestCase
{
    /**
     * Проверить валидацию верных параметров.
     * @return void
     * @throws UniException
     * @dataProvider getSuccessfulParams
     */
    public function testSuccessfulValidate(array $successfulParams)
    {
        $this->expectNotToPerformAssertions();
        ValidateProductsSearchParams::validate($successfulParams, [10, 15, 25]);
    }

    /**
     * Проверить валдидацию неверных параметров.
     * @return void
     * @dataProvider getFailedParams
     */
    public function testFailedValidate($failedParams)
    {
        $this->expectException(UniException::class);

        ValidateProductsSearchParams::validate($failedParams, [10, 15, 25]);
    }

    public function getSuccessfulParams(): array
    {
        return [
            [[
                'count' => 25,
                'offset' => 10,
                'sortBy' => null,
                'query' => null
            ]],
            [[
                'count' => 10,
                'offset' => 0,
                'sortBy' => ['price' => 'asc'],
                'query' => null
            ]],
            [[
                'count' => 15,
                'offset' => 0,
                'sortBy' => null,
                'query' => 'prod'
            ]],
        ];
    }

    public function getFailedParams(): array
    {
        return [
            [[
                'count' => -25,
                'offset' => 10,
                'sortBy' => null,
                'query' => null
            ]],
            [[
                'count' => 10,
                'offset' => -10,
                'sortBy' => ['price' => 'asc'],
                'query' => null
            ]],
            [[
                'count' => 11,
                'offset' => 0,
                'sortBy' => [],
                'query' => 'prod'
            ]],
            [[
                'count' => 11,
                'offset' => 0,
                'sortBy' => [],
                'query' => str_repeat('f', Product::MAX_NAME_LENGTH + 1)
            ]],
        ];
    }
}