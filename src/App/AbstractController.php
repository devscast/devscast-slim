<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Router;
use Framework\Session\FlashMessage;
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

    /**
     * @param string $route
     * @param array $params
     * @param int $status
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function redirect(string $route, array $params = [], $status = 301): ResponseInterface
    {
        $uri = $this->router->pathFor($route, $params);
        return (new Response())->withRedirect($uri, $status);
    }
}
