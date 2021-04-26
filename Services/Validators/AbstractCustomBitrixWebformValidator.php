<?php

namespace Prokl\BitrixWebformBundle\Services\Validators;

use Prokl\BitrixWebformBundle\Services\Validators\Interfaces\BitrixCustomValidatorWebFormInterface;

/**
 * Class AbstractCustomBitrixWebformValidator
 * @package Prokl\BitrixWebformBundle\Services\Validators
 *
 * @since 06.02.2021
 */
class AbstractCustomBitrixWebformValidator implements BitrixCustomValidatorWebFormInterface
{
    /**
     * @inheritDoc
     */
    public function GetDescription() : array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function GetSettings() : array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function ToDB($arParams)
    {
       return serialize($arParams);
    }

    /**
     * @inheritDoc
     */
    public function FromDB($strParams)
    {
        return unserialize($strParams);
    }

    /**
     * @inheritDoc
     */
    public function DoValidate($arParams, $arQuestion, $arAnswers, $arValues) : bool
    {
          return true;
    }
}
