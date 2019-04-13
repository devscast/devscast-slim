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

use App\Repositories\QuotesRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;


/**
 * Class Resource
 * @package API\Resources
 *
 */
class Resource extends \App\Resources\Resource
{

    /**
     * Resource Repository
     * @var object $repository
     */
    protected  $repository;

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
        parent::__construct($container);
        $this->container = $container;
        $this->quote = $container->get(QuotesRepository::class)->random();
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
