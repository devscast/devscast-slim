<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Middlewares;

use Framework\Logger;
use Slim\Router;
use Slim\Http\Request;
use Slim\Http\Response;
use Framework\Auth\AuthInterface;
use Framework\Helpers\RouterAwareHelper;
use Slim\Interfaces\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LoggedInMiddleware
 * @package Framework\Middlewares
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
            Logger::info("Attempt access to backoffice", ['path' => $request->getUri()->getPath()]);
            return $this->redirect('auth.login');
        }
        return $next($request->withAttribute('user', $user), $response);
    }
}
