<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Middleware;

use Slim\Router;
use Framework\Logger;
use App\RouterAwareHelper;
use Framework\Auth\AuthInterface;
use Slim\Interfaces\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class LoggedInMiddleware
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Middlewares
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
     *
     * @param AuthInterface $auth
     * @param Router $router
     */
    public function __construct(AuthInterface $auth, Router $router)
    {
        $this->auth = $auth;
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
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
