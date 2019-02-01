<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Controllers;

use Core\CRUDInterface;
use App\Repositories\UsersRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class UsersController
 * @package Admin\Controllers
 */
class UsersController extends DashboardController implements CRUDInterface
{

    /**
     * @var UsersRepository|mixed
     */
    private $users;

    /**
     * UsersController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->users = $container->get(UsersRepository::class);
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement create() method.
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function store(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement store() method.
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function edit(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement edit() method.
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement update() method.
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // TODO: Implement delete() method.
    }
}
