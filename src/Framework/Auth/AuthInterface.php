<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Framework\Auth;

/**
 * Interface AuthInterface
 * @package Framework\Auth
 * @author bernard-ng, https://bernard-ng.github.io
 */
interface AuthInterface
{

    /**
     * Retrieve a logged user or null
     * @return User|null
     */
    public function getUser(): ?User;
}
