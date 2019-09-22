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

use Framework\Repositories\JsonFileRepository;

/**
 * Class FlashService
 * Flash Messages using Session
 * @package Framework\Session
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
        $this->messages = [];
    }

    /**
     * retrieve a message for a given key
     *
     * @param string $message
     * @param string $type
     * @return string
     */
    private function getMessage(string $message, string $type = 'success'): string
    {
        $messages = $this->messages->getData();
        return
            $message->en->{$type}->{$message} ??
            $message->fr->{$type}->{$message} ??
            $message;
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
        $flash['success'] = $this->getMessage($message, 'success');
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
        $flash['error'] = $this->getMessage($message, 'error');
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
        $flash['warning'] = $this->getMessage($message, 'warning');
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

    /**
     * Retrieve all flashes
     * @return array|null
     */
    public function getAll(): ?array
    {
        $flashes = $this->session->get(self::FLASH_SESSION_KEY, []);
        return $flashes ?? null;
    }


    /**
     * Reset flash message
     * @return void
     */
    public function reset(): void
    {
        $this->session->delete(self::FLASH_SESSION_KEY);
    }
}
