<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Session;

use Psr\Container\ContainerInterface;
use Framework\JsonReader;

/**
 * Class FlashMessageFactory
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Session
 */
class FlashMessageFactory
{

    /**
     * instance of the flashService
     *
     * @var FlashMessage
     */
    private $flashService;

    /**
     * create new instance of flash session
     *
     * @param ContainerInterface $container
     * @return FlashMessage
     */
    public function __invoke(ContainerInterface $container): FlashMessage
    {
        if (is_null($this->flashService)) {
            $session = $container->get(SessionInterface::class);
            $messages = new JsonReader($container->get('data.messages'));
            $this->flashService = new FlashMessage($session, $messages);
            return $this->flashService;
        }
        return $this->flashService;
    }
}
