<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Framework\Factories;

use Slim\Csrf\Guard;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SlimCSRFGuardFactory
 * @package Framework\Factories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class SlimCSRFGuardFactory
{

    /**
     * @return Guard
     */
    public function __invoke(): Guard
    {
        $guard = new Guard();
        $guard->setFailureCallable(
            function (ServerRequestInterface $request, ResponseInterface $response, $next): ResponseInterface {
                $request = $request->withAttribute("csrf_status", false);
                return $next($request, $response);
            }
        );
        return $guard;
    }
}
