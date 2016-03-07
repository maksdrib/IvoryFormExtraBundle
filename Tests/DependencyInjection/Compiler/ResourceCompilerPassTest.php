<?php

/*
 * This file is part of the Ivory Form Extra package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\FormExtraBundle\Tests\DependencyInjection\Compiler;

use Ivory\FormExtraBundle\DependencyInjection\Compiler\ResourceCompilerPass;

/**
 * Resource compiler pass test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class ResourceCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Ivory\FormExtraBundle\DependencyInjection\Compiler\ResourceCompilerPass */
    private $compilerPass;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->compilerPass = new ResourceCompilerPass();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->compilerPass);
    }

    public function testTwigResource()
    {
        $containerBuilder = $this->createContainerBuilderMock();
        $containerBuilder
            ->expects($this->exactly(2))
            ->method('hasParameter')
            ->will($this->returnValueMap(array(
                array('templating.helper.form.resources', false),
                array($parameter = 'twig.form.resources', true),
            )));

        $containerBuilder
            ->expects($this->once())
            ->method('getParameter')
            ->with($this->identicalTo($parameter))
            ->will($this->returnValue(array($template = 'layout.html.twig')));

        $containerBuilder
            ->expects($this->once())
            ->method('setParameter')
            ->with(
                $this->identicalTo($parameter),
                $this->identicalTo(array(
                    'IvoryFormExtraBundle:Form:javascript.html.twig',
                    'IvoryFormExtraBundle:Form:stylesheet.html.twig',
                    $template,
                ))
            );

        $this->compilerPass->process($containerBuilder);
    }

    public function testPhpResource()
    {
        $containerBuilder = $this->createContainerBuilderMock();
        $containerBuilder
            ->expects($this->exactly(2))
            ->method('hasParameter')
            ->will($this->returnValueMap(array(
                array($parameter = 'templating.helper.form.resources', true),
                array('twig.form.resources', false),
            )));

        $containerBuilder
            ->expects($this->once())
            ->method('getParameter')
            ->with($this->identicalTo($parameter))
            ->will($this->returnValue(array($template = 'layout.html.php')));

        $containerBuilder
            ->expects($this->once())
            ->method('setParameter')
            ->with(
                $this->identicalTo($parameter),
                $this->identicalTo(array('IvoryFormExtraBundle:Form', $template))
            );

        $this->compilerPass->process($containerBuilder);
    }

    /**
     * Creates a container builder mock.
     *
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private function createContainerBuilderMock()
    {
        return $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')
            ->disableOriginalConstructor()
            ->setMethods(array('hasParameter', 'getParameter', 'setParameter'))
            ->getMock();
    }
}
