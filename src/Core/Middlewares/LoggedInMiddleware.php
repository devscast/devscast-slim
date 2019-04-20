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
use Core\Helpers\RouterAwareHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;
use Slim\Router;

/**
 * Class LoggedInMiddleware
 * @package Core\Middlewares
 * @author bernard-ng, https://bernard-ng.github.io
 */
class LoggedInMiddleware
{

    use RouterAwareHelper;

    /**
     * @var AuthInterface
     */
    private $auth;
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * LoggedInMiddleware constructor.
     * @param AuthInterface $auth
     * @param RouterInterface|Router $router
     */
    public function __construct(AuthInterface $auth, Router $router)
    {
        $this->auth = $auth;
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $next
     * @return ResponseInterface|Response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        $user = $this->auth->getUser();
        if (is_null($user)) {
            return $this->redirect('auth.login');
        }
        return $next($request->withAttribute('user', $user), $response);
    }
}
