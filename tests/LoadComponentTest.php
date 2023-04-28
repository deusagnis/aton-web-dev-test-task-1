<?php

use App\Pages\LoadComponent;

class LoadComponentTest extends \PHPUnit\Framework\TestCase
{
    private string $testViewPath;
    private int $summand;

    protected function setUp(): void
    {
        $this->testViewPath = join(DIRECTORY_SEPARATOR, [__DIR__, '..', 'views', 'test.php']);
    }

    /**
     * Проверка загрузки тестового компонента.
     * @return void
     */
    public function testLoading()
    {
        $this->summand = 3;
        $sumBase = 4;

        $result = LoadComponent::load($this->testViewPath, $this, 'number', $sumBase, 'summand');

        $this->assertEquals('<div>number = 7</div>', trim($result));
    }
}