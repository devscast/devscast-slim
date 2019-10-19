<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Middleware;

use Slim\Router;
use App\RouterAwareHelper;
use Slim\Interfaces\RouterInterface;
use Framework\{Logger, Auth\AuthInterface};
use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Class LoggedInMiddleware
 * @todo Use the PSR-15 instead https://www.php-fig.org/psr/psr-15/
 * @package Framework\Middleware
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class LoggedInMiddleware
{

    use RouterAwareHelper;

    /** @var AuthInterface */
    private $auth;

    /** @var RouterInterface */
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
     * @param Callable $next
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        $user = $this->auth->getUser();
        if (is_null($user)) {
            Logger::info("Attempt access to backoffice", ['path' => $request->getUri()->getPath()]);
            return $this->redirect('admin.auth.login');
        }
        return $next($request->withAttribute('user', $user), $response);
    }
}
