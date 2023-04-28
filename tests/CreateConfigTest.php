<?php

use App\Config\CreateConfig;
use App\Env\LoadEnv;
use PHPUnit\Framework\TestCase;

class CreateConfigTest extends TestCase
{
    private string $configDirPath;

    protected function setUp(): void
    {
        $envDirPath = __DIR__ . DIRECTORY_SEPARATOR . '..';
        LoadEnv::load($envDirPath);

        $this->configDirPath = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'config']);
    }

    /**
     * Проверка создания правильного объекта конфигурации приложения.
     * @return void
     */
    public function testCreation()
    {
        $this->expectNotToPerformAssertions();
        try {
            $conf = CreateConfig::create($this->configDirPath);

            $conf->get('app.debug');
            $conf->get('app.prod');

            $conf->get('database.type');
            $conf->get('database.host');
            $conf->get('database.database');
            $conf->get('database.username');
            $conf->get('database.password');
        } catch (Throwable $exception) {
            $this->fail($exception->getMessage());
        }
    }
}