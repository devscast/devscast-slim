<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Framework\Renderer;

use nochso\HtmlCompressTwig\Extension;
use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Router;
use Slim\Views\TwigExtension;
use Twig\Extension\DebugExtension;
use Twig\Extensions\TextExtension;

/**
 * Class RendererFactory
 * @package Framework\Renderer
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
            'debug' => evalBool(getenv('APP_DEBUG'))
        ]);

        $router = $this->container->get(Router::class);
        $uri = Uri::createFromEnvironment(new Environment($_SERVER));
        $view->addExtension(new TwigExtension($router, $uri));
        $view->addExtension(new TextExtension());
        $view->addExtension(new Extension(true));

        foreach ($this->container->get('twig.extensions') as $extension) {
            $view->addExtension($this->container->get($extension));
        }

        if (evalBool(getenv('APP_DEBUG'))) {
            $view->addExtension(new DebugExtension());
        }
        return $view;
    }
}
