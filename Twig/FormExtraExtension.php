<?php

/*
 * This file is part of the Ivory Form Extra package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\FormExtraBundle\Twig;

use Symfony\Component\Form\FormRendererInterface;
use Symfony\Component\Form\FormView;

/**
 * Form Extra Twig extension.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class FormExtraExtension extends \Twig_Extension
{
    /** @var \Symfony\Component\Form\FormRendererInterface */
    private $renderer;

    /**
     * Creates a Form Javascript Twig extension.
     *
     * @param \Symfony\Component\Form\FormRendererInterface $renderer The form renderer
     */
    public function __construct(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new \Twig_SimpleFunction('form_javascript', array($this, 'javascript'), $options),
            new \Twig_SimpleFunction('form_stylesheet', array($this, 'stylesheet'), $options),
        );
    }

    /**
     * Renders a form javascript fragment.
     *
     * @param FormView $view      The form view.
     * @param array    $variables The extra variables
     *
     * @return string The rendered form javascript fragment.
     */
    public function javascript(FormView $view, array $variables = array())
    {
        return $this->renderer->searchAndRenderBlock($view, 'javascript', $variables);
    }

    /**
     * Renders a form stylesheet fragment.
     *
     * @param FormView $view      The form view.
     * @param array    $variables The extra variables
     *
     * @return string The rendered form stylesheet fragment.
     */
    public function stylesheet(FormView $view, array $variables = array())
    {
        return $this->renderer->searchAndRenderBlock($view, 'stylesheet', $variables);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ivory_form_extra';
    }
}
