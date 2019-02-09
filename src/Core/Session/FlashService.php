<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Session;

/**
 * Class FlashService
 * Flash Messages using Session
 * @package Core\Session
 * @author bernard-ng, https://bernard-ng.github.io
 */
class FlashService
{

    /**
     * To avoid conflict with defined key in session
     */
    private const FLASH_SESSION_KEY = 'flash';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * FlashService constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Set a success flash message
     * avoid to go too deep with array, so that we can use redis in the future
     * @param string $message
     * @return void
     */
    public function success(string $message): void
    {
        $flash = $this->session->get(self::FLASH_SESSION_KEY, []);
        $flash['success'] = $message;
        $this->session->set(self::FLASH_SESSION_KEY, $flash);
    }

    /**
     * Set a danger flash message
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        $flash = $this->session->get(self::FLASH_SESSION_KEY, []);
        $flash['error'] = $message;
        $this->session->set(self::FLASH_SESSION_KEY, $flash);
    }

    /**
     * Set a warning flash message
     * @param string $message
     * @return void
     */
    public function warning(string $message): void
    {
        $flash = $this->session->get(self::FLASH_SESSION_KEY, []);
        $flash['warning'] = $message;
        $this->session->set(self::FLASH_SESSION_KEY, $flash);
    }

    /**
     * Retrieve flash message thanks to its type
     * @param string $type
     * @return null|string
     */
    public function get(string $type): ?string
    {
        $flash = $this->session->get(self::FLASH_SESSION_KEY, []);
        if (array_key_exists($type, $flash)) {
            return $flash[$type];
        }
        return null;
    }
}
