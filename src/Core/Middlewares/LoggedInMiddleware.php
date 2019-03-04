<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */



namespace Core\Middlewares;

use Core\Auth\AuthInterface;
use Core\Auth\ForbiddenException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class LoggedInMiddleware
 * @package Core\Middlewares
 */
class LoggedInMiddleware
{

    /**
     * @var AuthInterface
     */
    private $auth;

    /**
     * LoggedInMiddleware constructor.
     * @param AuthInterface $auth
     */
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $next
     * @return ResponseInterface|Response
     * @throws ForbiddenException if the user is null
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        $user = $this->auth->getUser();
        if (is_null($user)) {
            throw new ForbiddenException();
        }
        return $next($request->withAttribute('user', $user), $response);
    }
}