<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Auth;

/**
 * Interface AuthInterface
 * @package Framework\Auth
 * @author bernard-ng <ngandubernard@gmail.com>
 */
interface AuthInterface
{

    /**
     * Retrieve a logged user or null
     *
     * @return UserInterface|null
     */
    public function getUser(): ?UserInterface;
}
