<?php

/*
 * This file is part of the Ivory Form Extra package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\FormExtraBundle;

use Ivory\FormExtraBundle\DependencyInjection\Compiler\ResourceCompilerPass;
use Ivory\FormExtraBundle\DependencyInjection\Compiler\TemplatingCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Ivory Form Javascript bundle.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class IvoryFormExtraBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container
            ->addCompilerPass(new ResourceCompilerPass())
            ->addCompilerPass(new TemplatingCompilerPass());
    }
}
