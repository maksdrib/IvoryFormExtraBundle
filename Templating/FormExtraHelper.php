<?php

/*
 * This file is part of the Ivory Form Extra package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Ivory\FormExtraBundle\Templating;

use Symfony\Component\Form\FormRendererInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Templating\Helper\Helper;

/**
 * Form Extra helper.
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class FormExtraHelper extends Helper
{
    /** @var \Symfony\Component\Form\FormRendererInterface */
    private $renderer;

    /**
     * Creates a Form Javascript helper.
     *
     * @param \Symfony\Component\Form\FormRendererInterface $renderer The form renderer.
     */
    public function __construct(FormRendererInterface $renderer)
    {
        $this->renderer = $renderer;
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
