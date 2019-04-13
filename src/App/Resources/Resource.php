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

use Core\Helpers\RouterAwareHelper;
use Core\MetaManager;
use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;
use Slim\Router;

/**
 * Class Resource
 * Super class for Resource classes
 * @package App\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class Resource
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Renderer|mixed
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


    use RouterAwareHelper;

    /**
     * Resource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->renderer = $container->get(Renderer::class);
        $this->router = $container->get(Router::class);
        $this->meta = $container->get(MetaManager::class);
        $this->container = $container;
    }
}
