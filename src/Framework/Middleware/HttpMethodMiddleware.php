<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HttpMethodMiddleware
 * @todo Use the PSR-15 instead https://www.php-fig.org/psr/psr-15/
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Middlewares
 */
class HttpMethodMiddleware
{
    /**
     * valid http method
     * @var array
     */
    private $methods = ['POST', 'DELETE', 'PUT', 'PATCH', 'OPTIONS', 'HEAD', 'GET'];

    /**
     * parse the request in order to overwrite the default http method with the one redefined
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param Callable $next
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        if ($request->getMethod() === "POST") {
            $method = $request->getParsedBody()['_method'] ?? null;
            if ($method && in_array(strtoupper($method), $this->methods)) {
                return $next($request->withMethod($method), $response);
            }
            return $next($request, $response);
        }
        return $next($request, $response);
    }
}
