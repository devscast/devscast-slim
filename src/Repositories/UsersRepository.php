<?php
namespace App\Repositories;

use App\Entities\UsersEntity;


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