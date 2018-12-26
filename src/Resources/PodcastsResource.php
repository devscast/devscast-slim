<?php
namespace App\Resources;


use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;

/**
 * Class PodcastsResource
 * @package App\Resources
 */
class PodcastsResource
{
    /**
     * podcasts table
     * @var PodcastsRepository|mixed
     */
    private $podcasts;

    /**
     * PodcastsResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->podcasts = $container->get(PodcastsRepository::class);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->withJson([
            'api.action' => 'listing all podcasts',
            'podcasts' => $this->podcasts->all()
        ]);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = intval($request->getAttribute('id'));
        $post = $this->podcasts->find($id);

        if ($post) {
            return $response->withJson([
                'api.action' => 'show a single podcast',
                'podcasts' => $post
            ]);
        } else {
            return $response->withStatus(404);
        }
    }
}