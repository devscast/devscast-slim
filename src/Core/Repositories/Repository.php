<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Repositories;

use Core\Database\Builder\Query;

/**
 * Class Repository
 * @package App
 */
class Repository
{

    /**
     * the entity of a repository
     * represents one record
     * @var string
     */
    protected $entity;

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Repository constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * simplify instanciation of the queryBuilder
     * @return Query
     */
    protected function makeQuery()
    {
        return new Query($this->pdo);
    }

    /**
     * save data in the database
     * @param array $data
     * @return bool|int
     */
    public function create(array $data)
    {
        return $this->makeQuery()->insertInto($this->table, $data)->execute();
    }

    /**
     * update data
     * @param int $id
     * @param array $data
     * @return bool|int|\PDOStatement
     */
    public function update(int $id, array $data)
    {
        return $this->makeQuery()->update($this->table, $data, $id)->execute();
    }

    /**
     * delete a data in the storage
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->makeQuery()->delete($this->table, $id)->execute();
    }

    /**
     * return the last inserted id
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * get all data of a database table
     * @return Object|array|mixed
     */
    public function all()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->orderBy("{$this->table}.id DESC")
            ->all()->get();
    }

    /**
     * get one record thanks to its 'id'
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.id = ?", compact('id'))
            ->all()->get(0);
    }

    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.{$field} = ?", [$field => $value])
            ->all()->get();
    }
}
