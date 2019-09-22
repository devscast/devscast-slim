<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Middlewares;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotFound;

/**
 * Class NotFoundMiddleware
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Middlewares
 */
class NotFoundMiddleware extends NotFound
{

    /**
     * @var RendererInterface|mixed
     */
    private $renderer;

    /**
     * NotFoundMiddleware constructor.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return mixed
     */
    protected function renderJsonNotFoundOutput()
    {
        return json_encode([
            "status" => 404,
            "message" => "Not Found"
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    protected function renderHtmlNotFoundOutput(ServerRequestInterface $request)
    {
        return $this->renderer->fetch('@errors/404.html.twig');
    }
}
