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
 * Class PHPSession
 * Implementation for PHP native Session
 * @package Core\Session
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PHPSession implements SessionInterface
{

    /**
     * Whether the session is active
     * @return void
     */
    private function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name("devscast_ssid");
            session_start();
        }
    }

    /**
     * Retrieve the value of the given $key or return
     * $default value
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * Set a $value for the given $key
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * unset the given $key
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }
}
