<?php

namespace Cases\Validators;

use Prokl\BitrixTestingTools\Base\BitrixableTestCase;
use Prokl\BitrixWebformBundle\Services\Validators\CFormValidatorNumber;
use Prokl\BitrixWebformBundle\Tests\Tools\InvalidIntegerForTestNumbers;
use Prokl\TestingTools\Traits\DataProvidersTrait;

/**
 * Class CFormValidatorNumberTest
 * @package Cases\Validators
 */
class CFormValidatorNumberTest extends BitrixableTestCase
{
    use DataProvidersTrait;

    /**
     * @var CFormValidatorNumber $obTestObject
     */
    protected $obTestObject;

    /**
     * Если все OK.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @dataProvider dataProviderGoodNumbers
     */
    public function testOkNumber($value) : void
    {
        $this->obTestObject = new CFormValidatorNumber();

        $result = $this->obTestObject->DoValidate(
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
            [$value],
        );

        $this->assertTrue($result);
    }

    /**
     * Невалидные значения.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @dataProvider dataProviderInvalidNumbers
     */
    public function testInvalidNumber($value) : void
    {
        $this->obTestObject = new CFormValidatorNumber();

        $result = $this->obTestObject->DoValidate(
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
            [$value],
        );

        $this->assertFalse($result);

        global $APPLICATION;
        $exceptionText = $APPLICATION->GetException();

        $this->assertSame(
            '#FIELD_NAME#: допустимы только числовые значения',
            $exceptionText->GetString()
        );
    }

    /**
     * Нормальные числа (в виде строки или числа).
     *
     * @return array
     */
    public function dataProviderGoodNumbers() : array
    {
        return [
            ['111'],
            [222],
            [-1],
            ['65000'],
            [65000],
        ];
    }

    /**
     * Невалидные числа.
     *
     * @return array
     */
    public function dataProviderInvalidNumbers() : array
    {
        return $this->provideDataFrom([
            new InvalidIntegerForTestNumbers()
        ]);
    }
}
