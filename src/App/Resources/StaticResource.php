<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Resources;

use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class StaticResource
 * Static pages provider this is only for the WebApp
 * @package App\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class StaticResource
{
    /**
     * StaticResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $container->get(Renderer::class);
    }


    /**
     * Render about page
     * @param RequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function about(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->renderer->render($response, 'about.html.twig');
    }


    /**
     * Render contact page
     * @param RequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function contact(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($request->isPost()) {
        }
        return $this->renderer->render($response, 'contact.html.twig');
    }
}
