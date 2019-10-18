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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Error\LoaderError;

/**
 * Class NotImplementedHandler
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class NotImplementedHandler
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
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $refererHeader = $request->getHeader('HTTP_REFERER');
        $referer = ($refererHeader) ? array_shift($refererHeader) : "/";
        return $this->renderer->render($response,"@errors/501.html.twig", compact('referer'));
    }
}
