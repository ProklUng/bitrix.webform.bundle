<?php

namespace Prokl\BitrixWebformBundle\Tests\Tools;

use Prokl\TestingTools\Traits\AbstractDataProvider;

/**
 * Class InvalidIntegerForTestNumbers
 * Невалидные цифровые значения для теста валидатора.
 * @package Prokl\BitrixWebformBundle\Tests\Tools
 */
class InvalidIntegerForTestNumbers extends AbstractDataProvider
{
    public function values()
    {
        return [
            'array' => $this->arrayOfStrings(),
            'boolean-false' => false,
            'boolean-true' => true,
            'float-negative' => $this->floatNegative(),
            'float-positive' => $this->floatPositive(),
            'float-zero' => 0.0,
            'integer-zero-casted-to-string' => (string)0,
            'null' => null,
            'object' => new \stdClass(),
            'resource' => $this->resource(),
            'string' => $this->string(),
        ];
    }

}
