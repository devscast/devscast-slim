<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Framework\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CheckMethodMiddleware
 * Check if there's _method field in $_POST
 * and then change the request method value to the
 * _method value
 * @package Framework\Middlewares
 * @author bernard-ng, https://bernard-ng.github.io
 */
class HttpMethodMiddleware
{

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param callable $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        if ($request->isPost()) {
            $method = $request->getParam('_method');
            if (in_array(strtoupper($method), ['POST', 'DELETE', 'PUT', 'PATCH', 'OPTIONS', 'HEAD', 'GET'])) {
                $request = $request->withMethod($method);
                return $next($request, $response);
            }
            return $next($request, $response);
        }
        return $next($request, $response);
    }
}
