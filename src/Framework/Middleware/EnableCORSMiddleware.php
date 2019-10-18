<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Middleware;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};

/**
 * Class EnableCORSMiddleware
 * @todo Use the PSR-15 instead https://www.php-fig.org/psr/psr-15/
 * @package Framework\Middlewares
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class EnableCORSMiddleware
{

    /** @var array */
    private $trustedOrigins;

    /**
     * EnableCORSMiddleware constructor.
     * @param array $trustedOrigins
     */
    public function __construct(array $trustedOrigins = [])
    {
        $this->trustedOrigins = $trustedOrigins;
    }

    /**
     * allows CORS for ajax requests
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $next
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface
    {
        $origin = !empty($this->allowOrigin) ? implode(", ", $this->allowOrigin) : "" ;

        /** @var $response ResponseInterface */
        $response = $next($request, $response);
        return $response
            ->withHeader('Access-Control-Allow-Origin', $origin)
            ->withHeader(
                'Access-Control-Allow-Headers',
                'X-Requested-With, Content-Type, Accept, Origin, Authorization'
            )
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->withHeader('X-Powered-By', APP_NAME);
    }
}
