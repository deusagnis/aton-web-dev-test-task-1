<?php

use App\Config\CreateConfig;
use App\Database\CreateConnection;
use App\Env\LoadEnv;
use League\Config\Configuration;
use PHPUnit\Framework\TestCase;

class CreateConnectionTest extends TestCase
{
    private string $envDirPath;
    private string $configDirPath;
    private Configuration $conf;

    protected function setUp(): void
    {
        $this->envDirPath = __DIR__ . DIRECTORY_SEPARATOR . '..';
        LoadEnv::load($this->envDirPath);

        $this->configDirPath = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'config']);
        $this->conf = CreateConfig::create($this->configDirPath);
    }

    /**
     * Проверка создания экземпляра соединения с БД.
     * @return void
     */
    public function testConnection()
    {
        $this->expectNotToPerformAssertions();
        try {
            CreateConnection::create($this->conf);
        } catch (\Throwable $exception) {
            $this->fail($exception->getMessage());
        }
    }
}