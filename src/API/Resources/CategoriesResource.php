<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace API\Resources;

use App\Repositories\CategoriesRepository;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesResource
 * @package API\Resources
 * @author bernard-ng, https://bernard-ng.github.io
 */
class CategoriesResource extends Resource
{

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->repository = $container->get(CategoriesRepository::class);
        $this->resourceName = "categories";
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
                $this->resourceName => $this->repository->all(),
                "quote" => $this->quote,
            ]
        ];
        return $response->withJson($data, $this->status);
    }
}
