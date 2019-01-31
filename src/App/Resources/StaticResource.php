<?php
namespace App\Resources;

use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Static pages provider
 * Class StaticResource
 * @package App\Resources
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
     * @param RequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function about(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->renderer->render($response, 'about.html.twig');
    }


    /**
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
