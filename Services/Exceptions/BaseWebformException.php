<?php

namespace Prokl\BitrixWebformBundle\Services\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;

/**
 * Class BaseException
 * @package Prokl\BitrixWebformBundle\Services\Exceptions
 * @codeCoverageIgnore
 *
 * @since 05.09.2020
 */
class BaseWebformException extends Exception implements ExceptionInterface, RequestExceptionInterface
{
    /**
     * Ошибку в строку.
     *
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
