<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Controllers;

use App\Repositories\CategoriesRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\NewsletterRepository;
use App\Repositories\PodcastsRepository;
use Core\Renderer\Renderer;
use Core\RouterAwareAction;
use Core\Session\SessionInterface;
use DI\Bridge\Slim\App;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

/**
 * Class DashboardController
 * @package Admin\Controllers
 */
class DashboardController
{

    use RouterAwareAction;

    /**
     * @var Renderer|mixed
     */
    protected $renderer;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var mixed|Router
     */
    protected $router;

    /**
     * @var SessionInterface|mixed
     */
    protected $session;


    /**
     * DashboardController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $container->get(Renderer::class);
        $this->router = $container->get(Router::class);
        $this->session = $container->get(SessionInterface::class);
    }


    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $podcasts = count($this->container->get(PodcastsRepository::class)->all());
        $gallery = count($this->container->get(GalleryRepository::class)->all());
        $categories = count($this->container->get(CategoriesRepository::class)->all());
        $newsletter = count($this->container->get(NewsletterRepository::class)->all());

        return $this->renderer->render(
            $response,
            'admin/index.html.twig',
            compact('podcasts', 'gallery', 'categories', 'newsletter')
        );
    }
}
