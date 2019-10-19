<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Handlers;

use Framework\Renderer\RendererInterface;
use Framework\Renderer\Twig\TwigRenderer;
use Slim\Handlers\NotAllowed;
use Twig\Error\LoaderError;

/**
 * Class ErrorHandler
 * @package App\Handlers
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class NotAllowedHandler extends NotAllowed
{

    /** @var RendererInterface */
    private $renderer;

    /**
     * ErrorHandler constructor.
     * @param RendererInterface|TwigRenderer $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param string[] $methods
     * @return string
     * @throws LoaderError
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function renderHtmlNotAllowedMessage($methods)
    {
        $methods = implode(", ", $methods);
        return $this->renderer->fetch("@errors/405.html.twig", compact('methods'));
    }
}
