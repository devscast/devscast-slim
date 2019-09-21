<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entities;

use Framework\Auth\User;

/**
 * Class UsersEntity
 * Represent a user
 * @package App\Entities
 * @author bernard-ng, https://bernard-ng.github.io
 */
class UsersEntity implements User
{

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;



    /**
     * Retrieve the username
     * @return string
     */
    public function getUsername(): string
    {
        return $this->name;
    }

    /**
     * Retrieve the roles of a user
     * @return array
     */
    public function getRoles(): array
    {
        return [];
    }
}
