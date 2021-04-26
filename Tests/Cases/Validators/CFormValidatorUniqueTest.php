<?php

namespace Cases\Validators;

use Mockery;
use Prokl\BitrixTestingTools\Base\BitrixableTestCase;
use Prokl\BitrixTestingTools\Traits\BitrixExceptionAssertTrait;
use Prokl\BitrixWebformBundle\Services\FormSearcher;
use Prokl\BitrixWebformBundle\Services\Validators\CFormValidatorUnique;

/**
 * Class CFormValidatorUniqueTest
 * @package Cases\Validators
 */
class CFormValidatorUniqueTest extends BitrixableTestCase
{
    use BitrixExceptionAssertTrait;

    /**
     * @var CFormValidatorUnique $obTestObject
     */
    protected $obTestObject;

    /**
     * Если все OK - такой записи нет.
     *
     * @return void
     */
    public function testNonUnique() : void
    {
        $this->obTestObject = new CFormValidatorUnique(
            $this->getMockFormSearch(false)
        );

        $result = $this->obTestObject->DoValidate(
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
        );

        $this->assertTrue($result);
    }

    /**
     * Такая запись есть.
     *
     * @return void
     */
    public function testUnique() : void
    {
        $this->obTestObject = new CFormValidatorUnique(
            $this->getMockFormSearch(true)
        );

        $result = $this->obTestObject->DoValidate(
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
        );

        $this->assertFalse($result);

        $this->willExpectBitrixExceptionMessage("#FIELD_NAME#: такое значение уже существует в базе.");
    }

    /**
     * Мок FormSearcher.
     *
     * @param boolean $answer Ответ валидатора. true -> OK, false -> валидация не прошла.
     *
     * @return mixed
     */
    private function getMockFormSearch(bool $answer = true) {
        $mock = Mockery::mock(FormSearcher::class);

        $mock->shouldReceive('exist')
                ->once()
                ->andReturn($answer);

        $mock = $mock->shouldReceive('addFilter');
        $mock = $mock->shouldReceive('setIdForm');

        return $mock->getMock();
    }
}
