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

use App\Repositories\PodcastsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class HomeResource
 * @package API\Resources
 */
class HomeResource
{

    public function __construct(ContainerInterface $container)
    {
        $this->repository = $container->get(PodcastsRepository::class);
    }


    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface|\Slim\Http\Response $response
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $this->repository->all();
        return $response->withJson($data, 200);
    }

}