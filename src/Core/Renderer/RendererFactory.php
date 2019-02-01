<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Renderer;

use nochso\HtmlCompressTwig\Extension;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Router;
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
        $view->addExtension(new \Twig_Extensions_Extension_Text());
        $view->addExtension(new Extension());

        if ($this->container->get('settings.displayErrorDetails')) {
            $view->addExtension(new \Twig_Extension_Debug());
        }
        return $view;
    }
}
