<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace API\Resources;

use Modules\Page\QuotesRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Slim\Http\StatusCode;

/**
 * Class Resource
 * @todo generate documentation whit swagger
 * @package API\Resources
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class Resource
{

    /**
     * Resource Repository
     * @var object $repository
     */
    protected $repository;

    /**
     * HTTP response code
     * @var int
     */
    protected $status = StatusCode::HTTP_OK;

    /**
     * @var string $resourceName
     */
    protected $resourceName;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Global quote
     * @var null|\stdClass
     */
    protected $quote;

    /**
     * Resource constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->quote = $container->get(QuotesRepository::class)->random();
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
                $this->resourceName => $this->repository->all(),
                "quote" => $this->quote,
            ]
        ];
        return $response->withJson($data, $this->status, JSON_UNESCAPED_SLASHES);
    }
}
