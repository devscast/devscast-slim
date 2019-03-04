<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Core\Auth;

/**
 * Class User
 * @package Core\Auth
 */
interface User
{

    /**
     * Retrieve the username
     * @return string
     */
    public function getUsername(): string;

    /**
     * Retrieve the roles of a user
     * @return array
     */
    public function getRoles(): array;
}
