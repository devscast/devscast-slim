<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql\Builder\Queries;

use ArrayIterator;
use Framework\Database\Mysql\Builder\Exception;
use Framework\Database\Mysql\Builder\Query;
use Framework\Database\Mysql\Builder\Utilities;
use Countable;
use PDO;
use PDOStatement;

/**
 * Class Select
 * SELECT Query builder
 * @package Framework\Database\Builder\Queries
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Select extends Common implements Countable
{

    /** @var mixed */
    private $fromTable;
    /** @var mixed */
    private $fromAlias;

    /**
     * SelectQuery constructor.
     *
     * @param Query $fluent
     * @param           $from
     */
    public function __construct(Query $fluent, $from)
    {
        $clauses = [
            'SELECT' => ', ',
            'FROM' => null,
            'JOIN' => [$this, 'getClauseJoin'],
            'WHERE' => [$this, 'getClauseWhere'],
            'GROUP BY' => ',',
            'HAVING' => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT' => null,
            'OFFSET' => null,
            "\n--" => "\n--"
        ];
        parent::__construct($fluent, $clauses);

        // initialize statements
        $fromParts = explode(' ', $from);
        $this->fromTable = reset($fromParts);
        $this->fromAlias = end($fromParts);

        $this->statements['FROM'] = $from;
        $this->statements['SELECT'][] = $this->fromAlias . '.*';
        $this->joins[] = $this->fromAlias;
    }

    /**
     * Return table name from FROM clause
     */
    public function getFromTable()
    {
        return $this->fromTable;
    }

    /**
     * Return table alias from FROM clause
     */
    public function getFromAlias()
    {
        return $this->fromAlias;
    }

    /**
     * Fetch first row or column
     *
     * @param string $column - column name or empty string for the whole row
     * @param int $cursorOrientation
     *
     * @throws Exception
     *
     * @return mixed string, array or false if there is no row
     */
    public function fetch(?string $column = null, int $cursorOrientation = PDO::FETCH_ORI_NEXT)
    {
        if ($this->result === null) {
            $this->execute();
        }

        if ($this->result === false) {
            return false;
        }

        $row = $this->result->fetch($this->currentFetchMode, $cursorOrientation);

        if ($this->fluent->convertRead === true) {
            $row = Utilities::stringToNumeric($this->result, $row);
        }

        if ($row && $column !== null) {
            if (is_object($row)) {
                return $row->{$column};
            } else {
                return $row[$column];
            }
        }

        return $row;
    }

    /**
     * Fetch pairs
     *
     * @param $key
     * @param $value
     * @param $object
     *
     * @return array|PDOStatement
     *@throws Exception
     *
     */
    public function fetchPairs($key, $value, $object = false)
    {
        if (($s = $this->select("$key, $value", true)->asObject($object)->execute()) !== false) {
            return $s->fetchAll(PDO::FETCH_KEY_PAIR);
        }

        return $s;
    }

    /**
     * @param mixed $columns
     * @param bool $overrideDefault
     *
     * @return $this
     */
    public function select($columns, bool $overrideDefault = false)
    {
        if ($overrideDefault === true) {
            $this->resetClause('SELECT');
        } elseif ($columns === null) {
            return $this->resetClause('SELECT');
        }

        $this->addStatement('SELECT', $columns, []);

        return $this;
    }

    /**
     * \Countable interface doesn't break current select query
     *
     * @throws Exception
     *
     * @return int
     */
    public function count()
    {
        $fluent = clone $this;
        return (int)$fluent->select('COUNT(id)', true)->fetchColumn();
    }

    /**
     * Returns a single column
     *
     * @param int $columnNumber
     *
     * @throws Exception
     *
     * @return string
     */
    public function fetchColumn(int $columnNumber = 0)
    {
        if (($s = $this->execute()) !== false) {
            return $s->fetchColumn($columnNumber);
        }

        return $s;
    }

    /**
     * @return ArrayIterator|PDOStatement
     *@throws Exception
     *
     */
    public function getIterator()
    {
        if ($this->fluent->convertRead === true) {
            return new ArrayIterator($this->fetchAll());
        } else {
            return $this->execute();
        }
    }

    /** Fetch all row
     *
     * @param string $index - specify index column. Allows for data organization by field using 'field[]'
     * @param string $selectOnly - select columns which could be fetched
     *
     * @throws Exception
     *
     * @return array|bool -  fetched rows
     */
    public function fetchAll($index = '', $selectOnly = '')
    {
        $indexAsArray = strpos($index, '[]');

        if ($indexAsArray !== false) {
            $index = str_replace('[]', '', $index);
        }

        if ($selectOnly) {
            $this->select($index . ', ' . $selectOnly, true);
        }

        if ($index) {
            return $this->buildSelectData($index, $indexAsArray);
        } else {
            if (($result = $this->execute()) !== false) {
                if ($this->fluent->convertRead === true) {
                    return Utilities::stringToNumeric($result, $result->fetchAll());
                } else {
                    return $result->fetchAll();
                }
            }

            return false;
        }
    }

    /**
     * @param $index
     * @param $indexAsArray
     *
     * @return array
     */
    private function buildSelectData($index, $indexAsArray)
    {
        $data = [];

        foreach ($this as $row) {
            if (is_object($row)) {
                $key = $row->{$index};
            } else {
                $key = $row[$index];
            }

            if ($indexAsArray) {
                $data[$key][] = $row;
            } else {
                $data[$key] = $row;
            }
        }

        return $data;
    }
}
