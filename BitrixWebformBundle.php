<?php

namespace Prokl\BitrixWebformBundle;

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Prokl\BitrixWebformBundle\DependencyInjection\BitrixWebformExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class BitrixWebformBundle
 * @package Prokl\BitrixWebformBundle
 *
 * @since 06.02.2021
 */
class BitrixWebformBundle extends Bundle
{
   /**
   * @inheritDoc
   */
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new BitrixWebformExtension();
        }

        return $this->extension;
    }

    /**
     * @inheritDoc
     * @throws LoaderException
     */
    public function build(ContainerBuilder $container) : void
    {
        parent::build($container);

        Loader::includeModule('form');
    }
}
