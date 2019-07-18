<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace API\Resources;

use App\Repositories\PodcastLinksRepository;
use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class PodcastsResource
 * @package API\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PodcastsResource extends Resource
{

    /**
     * PodcastsResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(PodcastsRepository::class);
        $this->resourceName = "podcasts";
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = [
            "status" => $this->status,
            "data" => [
                "podcasts" => $this->repository->all(),
                "last" => $this->repository->latest(3),
                "hero" => $this->repository->last(),
                "quote" => $this->quote
            ],
        ];
        return $response->withJson($data, $this->status);
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface|Response
     */
    public function show(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $id = intval($request->getAttribute('route')->getArgument('id'));
        $podcast = $this->repository->find($id);

        if ($podcast) {
            $data = [
                "status" => $this->status,
                "data" => [
                    "podcast" => $podcast,
                    "last" => $this->repository->latest(3),
                    "next" => $this->repository->next($podcast->id),
                    "previous" => $this->repository->previous($podcast->id),
                    "links" => $this->container->get(PodcastLinksRepository::class)->get($id)
                ]
            ];
            return $response->withJson($data, $this->status);
        }
        return $response->withStatus(StatusCode::HTTP_NOT_FOUND);
    }
}
