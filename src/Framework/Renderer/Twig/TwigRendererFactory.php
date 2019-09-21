<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

use Psr\Container\ContainerInterface;
use Slim\Http\Environment;
use Slim\Http\Uri;
use Slim\Router;
use Slim\Views\TwigExtension;

/**
 * Class TwigRendererFactory
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class TwigRendererFactory
{

    /**
     * @param ContainerInterface $container
     * @return TwigRenderer
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $twig = new TwigRenderer(
            $container->get('renderer.twig.paths'),
            $container->get('renderer.twig.config')
        );

        $twig->addExtension(
            new TwigExtension(
                $container->get(Router::class),
                Uri::createFromEnvironment(new Environment($_SERVER))
            )
        );

        // Custom extensions
        foreach ($container->get('renderer.twig.extensions') as $extension) {
            $twig->addExtension($container->get($extension));
        }

        return $twig;
    }
}
