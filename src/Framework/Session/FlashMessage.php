<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Session;

use Framework\LangProvider;

/**
 * Class FlashMessage
 * @package Framework\Session
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class FlashMessage
{

    /**
     * To avoid conflict with defined key in session
     */
    private const FLASH_SESSION_KEY = 'flash';

    /** @var SessionInterface */
    private $session;

    /** @var LangProvider */
    private $messages;

    /**
     * FlashService constructor.
     *
     * @param SessionInterface $session
     * @param LangProvider $messages
     */
    public function __construct(SessionInterface $session, LangProvider $messages)
    {
        $this->session = $session;
        $this->messages = $messages->getData(true);
    }

    /**
     * retrieve a message for a given key
     * flash messages are defined in a json file for easy maintenance and updating
     * @param string $message
     * @return string
     */
    private function getMessage(string $message): string
    {
        return $this->messages[$message] ?? $message;
    }

    /**
     * Set a success flash message
     * avoid to go too deep with array, so that we can use redis in the future
     * @param string $message
     * @return void
     */
    public function success(string $message): void
    {
        $this->addMessage('success', $message);
    }

    /**
     * Set a danger flash message
     * @param string $message
     * @return void
     */
    public function error(string $message): void
    {
        $this->addMessage('error', $message);
    }

    /**
     * Set a warning flash message
     * @param string $message
     * @return void
     */
    public function warning(string $message): void
    {
        $this->addMessage('warning', $message);
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
        $this->session->delete(self::FLASH_SESSION_KEY);
        return $flashes;
    }

    /**
     * Reset flash message
     * @return void
     */
    public function reset(): void
    {
        $this->session->delete(self::FLASH_SESSION_KEY);
    }

    /**
     * set a flash message
     * @param string $type
     * @param string $message
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    private function addMessage(string $type, string $message)
    {
        $flash = $this->session->get(self::FLASH_SESSION_KEY, []);
        $flash[$type] = $this->getMessage($message);
        $this->session->set(self::FLASH_SESSION_KEY, $flash);
    }
}
