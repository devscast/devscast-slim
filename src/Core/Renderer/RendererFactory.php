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

use Core\Twig\FormTwigExtension;
use nochso\HtmlCompressTwig\Extension;
use Psr\Container\ContainerInterface;
use Slim\Csrf\Guard;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Router;
use Slim\Views\TwigExtension;

/**
 * Class RendererFactory
 * @package Core\Renderer
 * @author bernard-ng, https://bernard-ng.github.io
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
            'cache' => $this->container->get('views.cache'),
            'debug' => $this->container->get('settings.displayErrorDetails')
        ]);

        $router = $this->container->get(Router::class);
        $uri = Uri::createFromEnvironment(new Environment($_SERVER));
        $view->addExtension(new TwigExtension($router, $uri));
        $view->addExtension(new \Twig_Extensions_Extension_Text());
        $view->addExtension(new Extension());
        $view->addExtension(new FormTwigExtension($this->container->get(Guard::class)));

        if ($this->container->get('settings.displayErrorDetails')) {
            $view->addExtension(new \Twig_Extension_Debug());
        }
        return $view;
    }
}
