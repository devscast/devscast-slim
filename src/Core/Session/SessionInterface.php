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
 * Interface SessionInterface
 * @package Core\Session
 * @author bernard-ng, https://bernard-ng.github.io
 */
interface SessionInterface
{

    /**
     * Retrieve the value of the given $key or return
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Set a $value for the given $key
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * Unset the given $key
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}
