<?php

use App\Env\LoadEnv;
use PHPUnit\Framework\TestCase;

class LoadEnvTest extends TestCase
{
    private string $envDirPath;

    protected function setUp(): void
    {
        $this->envDirPath = __DIR__ . DIRECTORY_SEPARATOR . '..';
    }

    /**
     * Проверить загрузку переменных среды из файла .env.
     * @return void
     */
    public function testLoading()
    {
        LoadEnv::load($this->envDirPath);

        $this->assertArrayHasKey('DEBUG', $_ENV);
        $this->assertArrayHasKey('PROD', $_ENV);
        $this->assertArrayHasKey('DB_TYPE', $_ENV);
        $this->assertArrayHasKey('DB_HOST', $_ENV);
        $this->assertArrayHasKey('DB_NAME', $_ENV);
        $this->assertArrayHasKey('DB_USERNAME', $_ENV);
        $this->assertArrayHasKey('DB_PASSWORD', $_ENV);
    }
}