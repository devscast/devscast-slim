<?php

namespace Core\Renderer;


use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Router;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

/**
 * Class RendererFactory
 * @package Core\Renderer
 */
class RendererFactory
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * RendererFactory constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return Renderer
     */
    public function __invoke(): Renderer
    {
        $view = new Renderer($this->container->get('views.path'), [
            'cache' => $this->container->get('views.cache')
        ]);

        $router = $this->container->get(Router::class);
        $uri = Uri::createFromEnvironment(new Environment($_SERVER));
        $view->addExtension(new TwigExtension($router, $uri));
        return $view;
    }
}