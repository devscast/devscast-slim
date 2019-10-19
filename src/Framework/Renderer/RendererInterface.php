<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Renderer;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface RendererInterface
 * @package Framework\Renderer
 * @author bernard-ng <ngandubernard@gmail.com>
 */
interface RendererInterface
{
    /**
     * Render a view
     * @param ResponseInterface $response
     * @param string $view
     * @param array $params
     * @return mixed
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function render(ResponseInterface $response, string $view, array $params = []);
}
