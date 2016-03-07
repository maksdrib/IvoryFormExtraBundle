<?php

/*
 * This file is part of the Ivory Form Extra package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\FormExtraBundle\Tests\DependencyInjection;

use Ivory\FormExtraBundle\DependencyInjection\IvoryFormExtraExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Ivory Form Javascript extension test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class IvoryFormExtraExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\DependencyInjection\ContainerBuilder */
    private $container;

    /** @var \Symfony\Component\Form\FormRendererInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $formRendererMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->formRendererMock = $this->getMock('Symfony\Component\Form\FormRendererInterface');

        $this->container = new ContainerBuilder();
        $this->container->set('templating.form.renderer', $this->formRendererMock);
        $this->container->set('twig.form.renderer', $this->formRendererMock);

        $this->container->registerExtension($extension = new IvoryFormExtraExtension());
        $this->container->loadFromExtension($extension->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->container);
    }

    public function testTemplatingHelper()
    {
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition($helper = 'ivory_form_extra.templating.helper'));
        $this->assertTrue($this->container->getDefinition($helper)->hasTag($tag = 'templating.helper'));

        $this->assertSame(
            array(array('alias' => 'ivory_form_extra')),
            $this->container->getDefinition($helper)->getTag($tag)
        );

        $this->assertInstanceOf('Ivory\FormExtraBundle\Templating\FormExtraHelper', $this->container->get($helper));
    }

    public function testTwigExtension()
    {
        $this->container->compile();

        $this->assertTrue($this->container->hasDefinition($helper = 'ivory_form_extra.twig.extension'));
        $this->assertTrue($this->container->getDefinition($helper)->hasTag($tag = 'twig.extension'));
        $this->assertInstanceOf('Ivory\FormExtraBundle\Twig\FormExtraExtension', $this->container->get($helper));
    }
}
