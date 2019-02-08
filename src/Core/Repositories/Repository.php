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

use Core\Database\DatabaseInterface;

/**
 * Class Repository
 * @TODO : replace with a query builder
 * @package App
 */
class Repository
{
    /**
     * the repository table name in database
     * @var string
     */
    protected $table;


    /**
     * the entity class
     * @var mixed
     */
    protected $entity;

    /**
     * the prefix of tables
     * @var string
     */
    protected $prefix;


    /**
     * database connexion
     * @var DatabaseInterface
     */
    private $db;


    /**
     * Repository constructor.
     * @param DatabaseInterface $database
     * @param string $prefix
     */
    public function __construct(DatabaseInterface $database, string $prefix = '')
    {
        $this->prefix = $prefix;
        $this->db = $database;
    }


    /**
     * @param string $statement
     * @param array $data
     * @param bool $entity
     * @param bool $fetchAll
     * @return mixed
     */
    final protected function query(string $statement, array $data = [], bool $entity = true, bool $fetchAll = true)
    {
        $entity = ($entity) ? $this->entity ?? null : null;
        return (empty($data)) ?
            $this->db->query($statement, $entity, $fetchAll) :
            $this->db->prepare($statement, $data, $entity, $fetchAll);
    }


    /**
     * save data in the database
     * @param array $data
     * @param bool $created_at
     * @return mixed
     */
    public function create(array $data, $created_at = false)
    {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$this->getTable()}.{$key} = ?";
            $values[] = "{$value}";
        }
        $fields = implode(', ', $fields);

        if ($created_at) {
            return $this->query("INSERT INTO {$this->getTable()} SET {$fields}, created_at = NOW()", $values);
        }
        return $this->query("INSERT INTO {$this->getTable()} SET {$fields}", $values);
    }


    /**
     * update data
     * @param int $id
     * @param array $data
     * @param bool $updated_at
     * @return mixed
     */
    public function update(int $id, array $data, $updated_at = false)
    {
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            $fields[] = "{$key} = ?";
            $values[] = "{$value}";
        }
        $fields = implode(', ', $fields);
        $values[] = $id;

        if ($updated_at) {
            return $this->query("UPDATE {$this->getTable()} SET {$fields}, updated_at = NOW() WHERE id = ?", $values);
        }
        return $this->query("UPDATE {$this->getTable()} SET {$fields} WHERE {$this->getTable()}.id = ?", $values);
    }


    /**
     * delete a data in the storage
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->query("DELETE FROM {$this->getTable()} WHERE {$this->getTable()}.id = ?", [$id]);
    }


    /**
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->prefix . $this->table;
    }


    /**
     * get all data of a database table
     * @return mixed
     */
    public function all()
    {
        return $this->query("SELECT * FROM {$this->getTable()} ORDER BY {$this->getTable()}.id DESC");
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->query("SELECT * FROM {$this->getTable()} WHERE id = ?", [$id], true, false);
    }


    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->getTable()} WHERE {$field} = ?", [$value]);
    }
}
