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
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotFound;
use Twig\Error\LoaderError;

/**
 * Class ErrorHandler
 * @package App\Handlers
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class NotFoundHandler extends NotFound
{

    /** @var RendererInterface|TwigRenderer */
    private $renderer;

    /**
     * ErrorHandler constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     * @throws LoaderError
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function renderHtmlNotFoundOutput(ServerRequestInterface $request)
    {
        $refererHeader = $request->getHeader('HTTP_REFERER');
        $referer = ($refererHeader) ? array_shift($refererHeader) : "/";
        return $this->renderer->fetch("@errors/404.html.twig", compact("referer"));
    }
}
