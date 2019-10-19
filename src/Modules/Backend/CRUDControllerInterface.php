<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Backend;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface CRUDControllerInterface
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Modules\Backend
 */
interface CRUDControllerInterface
{

    /**
     * implementation should list all data for a particular module
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;

    /**
     * implementation should store new data for a particular module
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function create(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;

    /**
     * implementation should update data for a particular module
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function update(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;

    /**
     * implementation should destroy data for a particular module
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function delete(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}
