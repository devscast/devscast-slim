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
 * Class EnableCORSMiddleware
 * enable the cors for the frontend application
 * so that we can make ajax request to the backend application
 * @package App\Middlewares
 * @author bernard-ng, https://bernard-ng.github.io
 */
class EnableCORSMiddleware
{

    /**
     * @var array
     */
    private $allowOrigin;

    /**
     * EnableCORSMiddleware constructor.
     * @param array $allowOrigin
     */
    public function __construct(array $allowOrigin = [])
    {
        $this->allowOrigin = $allowOrigin;
    }

    /**
     * @param ServerRequestInterface|Request $request
     * @param ResponseInterface|Response $response
     * @param $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $origin = !empty($this->allowOrigin) ? implode(", ", $this->allowOrigin) : "" ;
        $response = $next($request, $response);
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('X-Powered-By', 'devscast');
    }
}
