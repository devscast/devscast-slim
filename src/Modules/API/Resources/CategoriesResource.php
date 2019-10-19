<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace API\Resources;

use App\Enumerations\ModulesEnum;
use Psr\Container\ContainerInterface;
use Modules\Podcast\Category\CategoriesRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CategoriesResource
 * @todo generate documentation whit swagger
 * @package API\Resources
 * @author bernard-ng <ngandubernard@gmail.com>
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
        $this->resourceName = ModulesEnum::CATEGORIES;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
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
        return $response->withJson($data, $this->status, JSON_UNESCAPED_SLASHES);
    }
}
