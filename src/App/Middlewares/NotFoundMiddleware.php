<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Middlewares;

use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\NotFound;
use Slim\Http\Response;

/**
 * Class NotFoundMiddleware
 * @package App\Middlewares
 */
class NotFoundMiddleware extends NotFound
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Renderer|mixed
     */
    private $renderer;

    /**
     * NotFoundMiddleware constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $container->get(Renderer::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @return string
     */
    protected function renderHtmlNotFoundOutput(ServerRequestInterface $request)
    {
        return $this->renderer->fetch('errors/404.html.twig');
    }
}
