<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Framework\Helpers;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

/**
 * Class RouterAwareHelper
 * Add Redirect Method for Classes that have the Router
 * @package Framework\Helpers
 * @author bernard-ng, https://bernard-ng.github.io
 */
trait RouterAwareHelper
{

    /**
     * Redirect to a specific route
     * @param int $status
     * @param string $path
     * @param array $params
     * @return ResponseInterface
     */
    public function redirect(string $path, array $params = [], int $status = 301): ResponseInterface
    {
        $uri = $this->router->pathFor($path, $params);
        return (new Response())->withRedirect($uri, $status);
    }
}
