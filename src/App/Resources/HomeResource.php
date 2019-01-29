<?php
namespace App\Resources;

use App\Repositories\PodcastsRepository;
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
     * HomeResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->podcasts = $container->get(PodcastsRepository::class);
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
        return $response->withJson([
            'api.action' => 'Listing latest podcasts',
            'podcasts' => $this->podcasts->latest(6)
        ]);
    }
}
