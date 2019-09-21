<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Handlers\AbstractHandler;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class JsonRequestMiddleware
 * check if the request is a json one and than return json instead of rendering views
 * @package App\Middlewares
 * @author bernard-ng, https://bernard-ng.github.io
 */
class JsonRequestMiddleware extends AbstractHandler
{

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        if ($this->determineContentType($request) === 'application/json') {
            return $next($request, $response);
        }

        $data = [
            'status' => StatusCode::HTTP_BAD_REQUEST,
            'message' => 'bad request : content-type application/json expected',
            'data' => [
                'currentContentType' => $this->determineContentType($request)
            ],
        ];
        return $response->withJson($data, StatusCode::HTTP_BAD_REQUEST);
    }
}
