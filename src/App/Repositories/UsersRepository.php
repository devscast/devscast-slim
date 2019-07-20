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

use App\Modules;
use Core\Logger;
use App\Entities\UsersEntity;
use Core\Repositories\Repository;
use Core\Database\Builder\Exception;

/**
 * Class UsersRepository
 * @package App\Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class UsersRepository extends Repository
{

    /**
     * The table name in the database
     * @var string
     */
    protected $table = Modules::USERS;

    /**
     * Entity class
     * @var string
     */
    protected $entity = UsersEntity::class;

    /**
     * Retrieve a record with a specific condition
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select("{$this->table}.*")
                ->where("{$this->table}.{$field} = ?", [$field => $value])
                ->all()->get(0);
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }
}
