<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;

trait RouterAwareHelper
{

    /**
     * @param string $route
     * @param array $params
     * @param int $status
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function redirect(string $route, array $params = [], $status = 301): ResponseInterface
    {
        $uri = $this->router->pathFor($route, $params);
        return (new Response())->withRedirect($uri, $status);
    }
}
