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
 * Interface AuthInterface
 * @package Core\Auth
 */
interface AuthInterface
{

    /**
     * Retrieve a logged user or null
     * @return User|null
     */
    public function getUser(): ?User;
}