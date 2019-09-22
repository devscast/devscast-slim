<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\User;

use Framework\Auth\UserInterface;

/**
 * Class UsersEntity
 * Represent a user
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Entities
 */
class UsersEntity implements UserInterface
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
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->name;
    }

    /**
     * Retrieve the roles of a user
     *
     * @return array
     */
    public function getRoles(): array
    {
        return [];
    }
}
