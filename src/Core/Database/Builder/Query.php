<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Database\Builder;

use Core\Database\Builder\Queries\Delete;
use Core\Database\Builder\Queries\Insert;
use Core\Database\Builder\Queries\Select;
use Core\Database\Builder\Queries\Update;
use Core\Database\QueryResult;


/**
 * Class Query
 * @package Core\Database\Builder
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Query
{
    /** @var bool|callback */
    public $debug;

    /** @var bool - Determines whether to convert types when fetching rows from Select */
    public $convertRead = false;

    /** @var bool - Determines whether to convert types within Base::buildParameters() */
    public $convertWrite = false;

    /** @var bool - If a query errors, this determines how to handle it */
    public $exceptionOnError = false;

    /** @var \PDO */
    protected $pdo;

    /** @var Structure|null */
    protected $structure;
    /** @var string */
    protected $table;

    /** @var string */
    protected $prefix;

    /** @var string */
    protected $separator;

    /** @var string */
    private $entity;

    /**
     * Query constructor
     *
     * @param \PDO $pdo
     * @param Structure|null $structure
     */
    public function __construct(\PDO $pdo, Structure $structure = null)
    {
        $this->pdo = $pdo;

        if ($this->pdo->getAttribute(\PDO::ATTR_ERRMODE) === \PDO::ERRMODE_EXCEPTION) {
            $this->throwExceptionOnError(true);
        }

        if (!$structure) {
            $structure = new Structure();
        }

        $this->structure = $structure;
    }

    /**
     * @param bool $flag
     */
    public function throwExceptionOnError(bool $flag): void
    {
        $this->exceptionOnError = $flag;
    }

    /**
     * @param string $entity
     * @return $this
     */
    public function into(string $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Create SELECT query from $table
     *
     * @param string $table - db table name
     * @param int $primaryKey - return one row by primary key
     *
     * @return Select
     *
     * @throws Exception
     */
    public function from(?string $table = null, ?int $primaryKey = null): Select
    {
        $this->setTableName($table);
        $table = $this->getFullTableName();

        $query = new Select($this, $table);

        if ($primaryKey !== null) {
            $tableTable = $query->getFromTable();
            $tableAlias = $query->getFromAlias();
            $primaryKeyName = $this->structure->getPrimaryKey($tableTable);
            $query = $query->where("$tableAlias.$primaryKeyName", $primaryKey);
        }

        return $query;
    }

    /**
     * Set table name comprised of prefix.separator.table
     *
     * @param string $table
     * @param string $prefix
     * @param string $separator
     *
     * @return self
     *
     * @throws Exception
     */
    public function setTableName(?string $table = '', string $prefix = '', string $separator = ''): Query
    {
        if ($table !== null) {
            $this->prefix = $prefix;
            $this->separator = $separator;
            $this->table = $table;
        }

        if ($this->getFullTableName() === '') {
            throw new Exception('Table name cannot be empty');
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getFullTableName(): string
    {
        return $this->prefix . $this->separator . $this->table;
    }

    /**
     * Create INSERT INTO query
     *
     * @param string $table
     * @param array $values - accepts one or multiple rows, @see docs
     *
     * @return Insert
     *
     * @throws Exception
     */
    public function insertInto(?string $table = null, array $values = []): Insert
    {
        $this->setTableName($table);
        $table = $this->getFullTableName();

        $query = new Insert($this, $table, $values);

        return $query;
    }

    /**
     * Create UPDATE query
     *
     * @param string $table
     * @param array|string $set
     * @param int $primaryKey
     *
     * @return Update
     *
     * @throws Exception
     */
    public function update(?string $table = null, $set = [], ?int $primaryKey = null): Update
    {
        $this->setTableName($table);
        $table = $this->getFullTableName();

        $query = new Update($this, $table);

        $query->set($set);
        if ($primaryKey) {
            $primaryKeyName = $this->getStructure()->getPrimaryKey($this->table);
            $query = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    /**
     * @return Structure
     */
    public function getStructure(): Structure
    {
        return $this->structure;
    }

    /**
     * Create DELETE query
     *
     * @param string $table
     * @param int $primaryKey delete only row by primary key
     *
     * @return Delete
     *
     * @throws Exception
     */
    public function delete(?string $table = null, ?int $primaryKey = null): Delete
    {
        $this->setTableName($table);
        $table = $this->getFullTableName();

        $query = new Delete($this, $table);

        if ($primaryKey) {
            $primaryKeyName = $this->getStructure()->getPrimaryKey($this->table);
            $query = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    /**
     * Create DELETE FROM query
     *
     * @param string $table
     * @param int $primaryKey
     *
     * @return Delete
     */
    public function deleteFrom(?string $table = null, ?int $primaryKey = null): Delete
    {
        $args = func_get_args();

        return call_user_func_array([$this, 'delete'], $args);
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }

    /**
     * Closes the \PDO connection to the database
     */
    public function close(): void
    {
        $this->pdo = null;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param bool $read
     * @param bool $write
     */
    public function convertTypes(bool $read, bool $write): void
    {
        $this->convertRead = $read;
        $this->convertWrite = $write;
    }

    /**
     * @param bool $flag
     */
    public function convertReadTypes(bool $flag): void
    {
        $this->convertRead = $flag;
    }

    /**
     * @param bool $flag
     */
    public function convertWriteTypes(bool $flag): void
    {
        $this->convertWrite = $flag;
    }

    /**
     * get the entity
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }
}
