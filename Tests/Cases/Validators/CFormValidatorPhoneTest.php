<?php

namespace Cases\Validators;

use Prokl\BitrixTestingTools\Base\BitrixableTestCase;
use Prokl\BitrixWebformBundle\Services\Validators\CFormValidatorPhone;

/**
 * Class CFormValidatorPhoneTest
 * @package Cases\Validators
 */
class CFormValidatorPhoneTest extends BitrixableTestCase
{
    /**
     * @var CFormValidatorPhone $obTestObject
     */
    protected $obTestObject;

    /**
     * Если все OK.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @dataProvider dataProviderGoodPhones
     */
    public function testOkNumber($value) : void
    {
        $this->obTestObject = new CFormValidatorPhone();

        $result = $this->obTestObject->DoValidate(
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
            [$value],
        );

        $this->assertTrue($result);
    }

    /**
     * Невалидные телефоны.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @dataProvider dataProviderInvalidPhones
     */
    public function testInvalidNumber($value) : void
    {
        $this->obTestObject = new CFormValidatorPhone();

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
            '#FIELD_NAME#: невалидный телефон',
            $exceptionText->GetString()
        );
    }

    /**
     * Нормальные телефоны.
     *
     * @return array
     */
    public function dataProviderGoodPhones() : array
    {
        return [
            ['89263612304'],
            ['+79263132345'],
            ['9263132345']
        ];
    }

    /**
     * Невалидные телефоны.
     *
     * @return array
     */
    public function dataProviderInvalidPhones() : array
    {
        return [
            ['926712345'],
            [926712345],
            ['xxxxxx'],
           ['+x3145678912'],
           ['99263622506'],
        ];
    }
}
