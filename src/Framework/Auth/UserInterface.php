<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Auth;

/**
 * Interface UserInterface
 * @package Framework\Auth
 * @author bernard-ng <ngandubernard@gmail.com>
 */
interface UserInterface
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
