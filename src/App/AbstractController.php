<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Modules;

use Slim\Router;
use Framework\MetaManager;
use Framework\Renderer\Renderer;
use Framework\Session\FlashService;
use Framework\Helpers\RouterAwareHelper;
use Psr\Container\ContainerInterface;

/**
 * Class Controller
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Modules
 */
class AbstractController
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
