<?php
namespace App\Resources;

use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Slim\Container;
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
     * the welcome text to the app
     *
     * @return string
     */
    public function index()
    {
        $response = new Response();
        return $response->withJson([
            'message' => 'Welcome to the devcast application',
            'podcasts' => $this->podcasts->all()
        ]);
    }
}
