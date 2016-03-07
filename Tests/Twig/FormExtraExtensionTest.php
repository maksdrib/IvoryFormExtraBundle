<?php

/*
 * This file is part of the Ivory Form Extra package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\FormExtraBundle\Tests\Twig;

use Ivory\FormExtraBundle\Twig\FormExtraExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Forms;

/**
 * Ivory Form Extra Twig extension test.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class FormExtraExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var \Twig_Environment */
    private $twig;

    /** @var \Symfony\Component\Form\FormFactoryInterface */
    private $formFactory;

    /** @var \Symfony\Bridge\Twig\Form\TwigRenderer */
    private $formRenderer;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->formFactory = Forms::createFormFactory();
        $this->formRenderer = new TwigRenderer(new TwigRendererEngine(array(
            'javascript.html.twig',
            'stylesheet.html.twig',
        )));

        $this->twig = new \Twig_Environment(new \Twig_Loader_Filesystem(array(
            __DIR__.'/../../Resources/views/Form',
            __DIR__.'/../Fixtures/views/Twig',
        )));

        $this->twig->addExtension($formExtension = new FormExtension($this->formRenderer));
        $this->twig->addExtension(new FormExtraExtension($this->formRenderer));

        $formExtension->initRuntime($this->twig);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        unset($this->formRenderer);
        unset($this->formFactory);
        unset($this->twig);
    }

    public function testDefaultJavascriptFragment()
    {
        $form = $this->formFactory->createBuilder()
            ->add('text', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm()
            ->createView();

        $template = $this->twig->createTemplate('{{ form_javascript(form) }}');

        $this->assertEmpty($template->render(array('form' => $form)));
    }

    public function testCustomJavascriptFragment()
    {
        $form = $this->formFactory->createBuilder()
            ->add('text', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm()
            ->createView();

        $this->formRenderer->setTheme($form, 'javascript_custom.html.twig');

        $template = $this->twig->createTemplate('{{ form_javascript(form) }}');

        $expected = '<script type="text/javascript">text-javascript</script>';
        $expected .= '<script type="text/javascript">submit-javascript</script>';

        $this->assertSame($expected, $template->render(array('form' => $form)));
    }

    public function testInheritanceJavascriptFragment()
    {
        $form = $this->formFactory->createBuilder()
            ->add('textarea', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm()
            ->createView();

        $this->formRenderer->setTheme($form, 'javascript_inheritance.html.twig');

        $template = $this->twig->createTemplate('{{ form_javascript(form) }}');

        $expected = '<script type="text/javascript">text-javascript</script>';
        $expected .= '<script type="text/javascript">button-javascript</script>';

        $this->assertSame($expected, $template->render(array('form' => $form)));
    }

    public function testDefaultStylesheetFragment()
    {
        $form = $this->formFactory->createBuilder()
            ->add('text', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm()
            ->createView();

        $template = $this->twig->createTemplate('{{ form_stylesheet(form) }}');

        $this->assertEmpty($template->render(array('form' => $form)));
    }

    public function testCustomStylesheetFragment()
    {
        $form = $this->formFactory->createBuilder()
            ->add('text', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm()
            ->createView();

        $this->formRenderer->setTheme($form, 'stylesheet_custom.html.twig');

        $template = $this->twig->createTemplate('{{ form_stylesheet(form) }}');

        $expected = '<style type="text/css">text-stylesheet</style>';
        $expected .= '<style type="text/css">submit-stylesheet</style>';

        $this->assertSame($expected, $template->render(array('form' => $form)));
    }

    public function testInheritanceStylesheetFragment()
    {
        $form = $this->formFactory->createBuilder()
            ->add('textarea', 'Symfony\Component\Form\Extension\Core\Type\TextareaType')
            ->add('submit', 'Symfony\Component\Form\Extension\Core\Type\SubmitType')
            ->getForm()
            ->createView();

        $this->formRenderer->setTheme($form, 'stylesheet_inheritance.html.twig');

        $template = $this->twig->createTemplate('{{ form_stylesheet(form) }}');

        $expected = '<style type="text/css">text-stylesheet</style>';
        $expected .= '<style type="text/css">button-stylesheet</style>';

        $this->assertSame($expected, $template->render(array('form' => $form)));
    }
}
