<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repositories;

use App\Entities\UsersEntity;
use Core\Repositories\Repository;

/**
 * Class UsersRepository
 * @package App\Repositories
 */
class UsersRepository extends Repository
{

    /**
     * the table name in database
     * @var string
     */
    protected $table = 'users';

    /**
     * the class that represents one user
     * @var UsersEntity
     */
    protected $entity = UsersEntity::class;
}
