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
 * Abstraction for a database table
 * @package Core/Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class Repository
{

    /**
     * The entity of a repository, represent one record
     * @var string
     */
    protected $entity;

    /**
     * The name of the table in the database
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
     * Simplify instantiation of the queryBuilder
     * @return Query
     */
    protected function makeQuery()
    {
        return new Query($this->pdo);
    }

    /**
     * Store data
     * @param array $data
     * @return bool|int
     */
    public function create(array $data)
    {
        return $this->makeQuery()->insertInto($this->table, $data)->execute();
    }

    /**
     * Update data
     * @param int $id
     * @param array $data
     * @return bool|int|\PDOStatement
     */
    public function update(int $id, array $data)
    {
        return $this->makeQuery()->update($this->table, $data, $id)->execute();
    }

    /**
     * Delete data
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->makeQuery()->delete($this->table, $id)->execute();
    }

    /**
     * Retrieve the last inserted id
     * @return string|int|mixed
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Retrieve all data
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
     * Retrieve one record thanks to its 'id'
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
     * Retrieve a record with a specific condition
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
