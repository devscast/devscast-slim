<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace API\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Response;
use Slim\Http\StatusCode;

/**
 * Class DefaultMiddleware
 * @package API\Middlewares
 * @author bernard-ng, https://bernard-ng.github.io
 */
class EnableAPIMiddleware
{

    /**
     * @var bool
     */
    private $enabled;

    /**
     * EnableAPIMiddleware constructor.
     * @param bool $enabled
     */
    public function __construct(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface|Response $response
     * @param $next
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        if ($this->enabled) {
            return $next($request, $response);
        }

        return $response->withJson([
            "message" => "Devscast API is unavailable for the moment",
            "status" => StatusCode::HTTP_SERVICE_UNAVAILABLE
        ], StatusCode::HTTP_SERVICE_UNAVAILABLE);
    }
}
