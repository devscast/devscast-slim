<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Framework\Session;

use Psr\Container\ContainerInterface;
use Framework\Repositories\JsonFileRepository;

/**
 * class FlashServiceFactory
 * @package Framework\Session
 * @author bernard-ng, https://bernard-ng.github.io
 */
class FlashServiceFactory
{

    /**
     * instance of the flashService
     * @var FlashService
     */
    private $flashService;

    /**
     * create new instance of flash session
     *
     * @param ContainerInterface $container
     * @return FlashService
     */
    public function __invoke(ContainerInterface $container): FlashService
    {
        if (is_null($this->flashService)) {
            $session = $container->get(SessionInterface::class);
            $messages = new JsonFileRepository($container->get('data.messages'));
            $this->flashService =  new FlashService($session, $messages);
            return $this->flashService;
        }
        return $this->flashService;
    }
}
