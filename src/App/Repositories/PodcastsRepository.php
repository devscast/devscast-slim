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

use App\Entities\PodcastsEntity;
use Core\Repositories\Repository;

/**
 * Class PodcastsRepository
 * @package App\Repositories
 */
class PodcastsRepository extends Repository
{

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table = 'podcasts';

    /**
     * the class that represents one podcast
     * @var PodcastsEntity
     */
    protected $entity = PodcastsEntity::class;


    /**
     * @inheritdoc
     * @return mixed
     */
    public function all()
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
ORDER BY {$this->getTable()}.id DESC
SQL;

        return $this->query($sql);
    }


    /**
     * Get the latest podcast
     * @param int $limit
     * @return mixed
     */
    public function latest(int $limit)
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
ORDER BY {$this->getTable()}.id DESC
LIMIT {$limit} OFFSET 0
SQL;
        return $this->query($sql);
    }


    /**
     * GET the last podcast
     * @return mixed
     */
    public function last()
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
ORDER BY {$this->getTable()}.id DESC
LIMIT 1
SQL;
        return $this->query($sql, [], true, false);
    }


    /**
     * get one podcast thanks to an 'id'
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
WHERE {$this->getTable()}.id = ?
ORDER BY {$this->getTable()}.id DESC
LIMIT 1
SQL;
        return $this->query($sql, [$id], true, false);
    }


    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
WHERE {$this->getTable()}.{$field} = ?
ORDER BY {$this->getTable()}.id DESC
SQL;
        return $this->query($sql, [$value]);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function next($id)
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
WHERE {$this->getTable()}.id > ?
LIMIT 1
SQL;
        return $this->query($sql, [$id], true, false);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function previous($id)
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
WHERE {$this->getTable()}.id < ?
ORDER BY {$this->getTable()}.id DESC
LIMIT 1
SQL;
        return $this->query($sql, [$id], true, false);
    }
}
