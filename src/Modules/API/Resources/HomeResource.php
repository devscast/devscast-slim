<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace API\Resources;

use Modules\Podcast\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Class HomeResource
 * @todo generate documentation whit swagger
 * @package API\Resources
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class HomeResource extends Resource
{

    /**
     * HomeResource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(PodcastsRepository::class);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = [
            "status" => $this->status,
            "data" => [
                "podcasts" => $this->repository->latest(10),
                "quote" => $this->quote
            ]
        ];
        return $response->withJson($data, $this->status, JSON_UNESCAPED_SLASHES);
    }
}
