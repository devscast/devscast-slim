<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Controllers;

use Slim\Router;
use Core\MetaManager;
use Core\Renderer\Renderer;
use Core\Session\FlashService;
use Core\Helpers\RouterAwareHelper;
use Psr\Container\ContainerInterface;

/**
 * Class Controller
 * Super class for Controller classes
 * @package App\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class Controller
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

    /**
     * @var FlashService
     */
    protected $flash;


    use RouterAwareHelper;

    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->renderer = $container->get(Renderer::class);
        $this->router = $container->get(Router::class);
        $this->meta = $container->get(MetaManager::class);
        $this->flash = $container->get(FlashService::class);
        $this->container = $container;
    }
}
