<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Middlewares;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * check if the request is a json one and than return json
 * instead of views
 * Class JsonRequestMiddleware
 * @package App\Middlewares
 */
class JsonRequestMiddleware
{

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        if ($request->getHeader('CONTENT_TYPE') != 'application/json') {
            if ($request->hasHeader('authorization')) {
                $request->withAttribute('IsJson', true);
            }
        }
        return $next($request, $response);
    }
}