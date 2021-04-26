<?php

namespace Cases\Validators;

use Egulias\EmailValidator\EmailValidator;
use Mockery;
use Prokl\BitrixTestingTools\Base\BitrixableTestCase;
use Prokl\BitrixWebformBundle\Services\Validators\CFormValidatorEmail;

/**
 * Class CFormValidatorEmailTest
 * @package Cases\Validators
 */
class CFormValidatorEmailTest extends BitrixableTestCase
{
    /**
     * @var CFormValidatorEmail $obTestObject
     */
    protected $obTestObject;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Если все OK.
     *
     * @return void
     */
    public function testOkEmail() : void
    {
        $this->obTestObject = new CFormValidatorEmail(
            $this->getMockEmailValidator(true)
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
     * Если email не прошел валидацию.
     *
     * @return void
     */
    public function testErrorEmail() : void
    {
        $this->obTestObject = new CFormValidatorEmail(
            $this->getMockEmailValidator(false)
        );

        $result = $this->obTestObject->DoValidate(
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
            ['test' => 'test'],
        );

        $this->assertFalse($result);

        global $APPLICATION;
        $exceptionText = $APPLICATION->GetException();

        $this->assertSame(
            "#FIELD_NAME#: невалидный адрес электронной почты",
            $exceptionText->GetString()
        );
    }

    /**
     * Мок EmailValidator.
     *
     * @param boolean $answer Ответ валидатора. true -> OK, false -> валидация не прошла.
     *
     * @return mixed
     */
    private function getMockEmailValidator(bool $answer = true) {
        $mock = Mockery::mock(EmailValidator::class)
                ->shouldReceive('isValid')
                ->once()
                ->andReturn($answer)
        ;

        return $mock->getMock();
    }
}
