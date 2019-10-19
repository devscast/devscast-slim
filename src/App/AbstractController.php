<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App;

use Framework\{Renderer\RendererInterface, Session\FlashMessage};
use Slim\Router;
use Psr\Container\ContainerInterface;

/**
 * Class AbstractController
 * @package App
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RendererInterface|mixed
     */
    protected $renderer;

    /**
     * @var mixed|Router
     */
    protected $router;

    /**
     * @var MetaManager|mixed
     */
    protected $meta;

    /**
     * @var FlashMessage
     */
    protected $flash;

    use RouterAwareHelper;

    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->renderer = $container->get(RendererInterface::class);
        $this->router = $container->get(Router::class);
        $this->meta = $container->get(MetaManager::class);
        $this->flash = $container->get(FlashMessage::class);
        $this->container = $container;
    }
}
