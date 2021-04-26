<?php

namespace Cases\Validators;

use Prokl\BitrixTestingTools\Base\BitrixableTestCase;
use Prokl\BitrixWebformBundle\Services\Validators\CFormValidatorTextLen;
use Prokl\TestingTools\Traits\DataProvidersTrait;

/**
 * Class CFormValidatorTextLenTest
 * @package Cases\Validators
 */
class CFormValidatorTextLenTest extends BitrixableTestCase
{
    use DataProvidersTrait;

    /**
     * @var CFormValidatorTextLen $obTestObject
     */
    protected $obTestObject;

    /**
     * Если все OK.
     *
     * @return void
     */
    public function testOkLength() : void
    {
        $this->obTestObject = new CFormValidatorTextLen();

        $result = $this->obTestObject->DoValidate(
            ['LENGTH_FROM' => 4, 'LENGTH_TO' => 100],
            ['test' => 'test'],
            ['test' => 'test'],
            [$this->faker->text(50)],
        );

        $this->assertTrue($result);
    }

    /**
     * Максимальная длина.
     *
     * @return void
     */
    public function testMaxLength() : void
    {
        $this->obTestObject = new CFormValidatorTextLen();

        do {
            $text = $this->faker->text(4250);
        } while (strlen($text) < 100);

        $result = $this->obTestObject->DoValidate(
            ['LENGTH_FROM' => 4, 'LENGTH_TO' => 100],
            ['test' => 'test'],
            ['test' => 'test'],
            [$text],
        );

        $this->assertFalse($result);

        global $APPLICATION;
        $exceptionText = $APPLICATION->GetException();

        $this->assertSame(
            'Ошибка по максимальной длине.',
            $exceptionText->GetString()
        );
    }

    /**
     * Максимальная длина.
     *
     * @return void
     */
    public function testMinLength() : void
    {
        $this->obTestObject = new CFormValidatorTextLen();

        $result = $this->obTestObject->DoValidate(
            ['LENGTH_FROM' => 100, 'LENGTH_TO' => 200],
            ['test' => 'test'],
            ['test' => 'test'],
            [$this->faker->text(50)],
        );

        $this->assertFalse($result);

        global $APPLICATION;
        $exceptionText = $APPLICATION->GetException();

        $this->assertSame(
            'Ошибка по минимальной длине.',
            $exceptionText->GetString()
        );
    }
}
