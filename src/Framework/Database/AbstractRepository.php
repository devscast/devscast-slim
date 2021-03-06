<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database;

use Exception;
use Framework\Database\Mysql\Builder\Query;
use Framework\Logger;
use PDO;
use PDOStatement;

/**
 * Class AbstractRepository
 * @package Framework\Database
 * @author bernard-ng <ngandubernard@gmail.com>
 */
class AbstractRepository
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

    /** @var PDO */
    private $pdo;

    /**
     * Repository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
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
        try {
            return $this->makeQuery()->insertInto($this->table, $data)->execute();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return false;
        }
    }

    /**
     * Update data
     * @param int $id
     * @param array $data
     * @return bool|int|PDOStatement
     */
    public function update(int $id, array $data)
    {
        try {
            return $this->makeQuery()->update($this->table, $data, $id)->execute();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return false;
        }
    }

    /**
     * Delete data
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        try {
            return $this->makeQuery()->delete($this->table, $id)->execute();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return false;
        }
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
     * @return Object|array|null
     */
    public function all()
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select("{$this->table}.*", true)
                ->orderBy("{$this->table}.id DESC")
                ->all()
                ->get();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve one record thanks to its 'id'
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select("{$this->table}.*", true)
                ->where("{$this->table}.id = ?", compact('id'))
                ->all()
                ->get(0);
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

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
                ->select("{$this->table}.*", true)
                ->where("{$this->table}.{$field} = ?", [$field => $value])
                ->all()
                ->get();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * @return int
     */
    public function count()
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select("{$this->table}.id", true)
                ->count();
        } catch (Exception $e) {
            Logger::error($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }
}
