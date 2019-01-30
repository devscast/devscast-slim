<?php
namespace App\Resources;

use App\Repositories\PodcastsRepository;
use Core\Renderer\Renderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class HomeResources
 * @package App\Resources
 */
class HomeResource
{

    /**
     * podcats table
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * HomeResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->podcasts = $container->get(PodcastsRepository::class);
        $this->renderer = $container->get(Renderer::class);
    }


    /**
     * [GET] the welcome text to the app
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|string
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $hero = $this->podcasts->last();
        $last = $this->podcasts->latest(3);
        $data = array_merge(['podcasts' => $last], compact('hero', 'last'));

        if ($request->getAttribute('isJson')) {
            return $response->withJson(array_merge(['api.message' => 'home page'], $data), 200);
        } else {
            return $this->renderer->render($response, 'index.html.twig', $data);
        }
    }
}
