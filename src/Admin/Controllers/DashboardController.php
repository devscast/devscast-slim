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
use Core\Helpers\RouterAwareHelper;
use Core\Renderer\Renderer;
use Core\Session\FlashService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Router;

/**
 * Class DashboardController
 * Super class for Controllers
 * @package Admin\Controllers
 * @author bernard-ng, https://bernard-ng.github.io
 */
class DashboardController
{

    /**
     * Add redirect method
     */
    use RouterAwareHelper;

    /**
     * response status of an action
     * @var int
     */
    protected $status = 200;

    /**
     * @var Renderer|mixed
     */
    protected $renderer;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Router|mixed
     */
    protected $router;

    /**
     * @var FlashService|mixed
     */
    protected $flash;


    /**
     * DashboardController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $container->get(Renderer::class);
        $this->router = $container->get(Router::class);
        $this->flash = $container->get(FlashService::class);
    }


    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $podcasts = $this->container->get(PodcastsRepository::class)->count();
        $gallery = $this->container->get(GalleryRepository::class)->count();
        $categories = $this->container->get(CategoriesRepository::class)->count();
        $newsletter = $this->container->get(NewsletterRepository::class)->count();

        return $this->renderer->render(
            $response,
            'admin/index.html.twig',
            compact('podcasts', 'gallery', 'categories', 'newsletter')
        );
    }

    /**
     * filters data sent by the user and retrieves only
     * that are valid
     * @param array $params
     * @param array $fields
     * @return array
     */
    protected function filter(array $params, array $fields): array
    {
        return array_filter($params, function ($key) use ($fields) {
            return in_array($key, $fields);
        }, ARRAY_FILTER_USE_KEY);
    }
}
