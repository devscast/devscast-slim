<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql\Builder\Queries;

use Framework\Database\Mysql\Builder\Exception;
use Framework\Database\Mysql\Builder\Literal;
use Framework\Database\Mysql\Builder\Query;

/**
 * Class Insert
 * INSERT query builder
 * @package Framework\Database\Builder\Queries
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Insert extends Base
{

    /** @var array */
    private $columns = [];

    /** @var array */
    private $firstValue = [];

    /** @var bool */
    private $ignore = false;

    /** @var bool */
    private $delayed = false;

    /**
     * InsertQuery constructor.
     *
     * @param Query $fluent
     * @param string $table
     * @param           $values
     *
     * @throws Exception
     */
    public function __construct(Query $fluent, $table, $values)
    {
        $clauses = [
            'INSERT INTO' => [$this, 'getClauseInsertInto'],
            'VALUES' => [$this, 'getClauseValues'],
            'ON DUPLICATE KEY UPDATE' => [$this, 'getClauseOnDuplicateKeyUpdate'],
        ];
        parent::__construct($fluent, $clauses);

        $this->statements['INSERT INTO'] = $table;
        $this->values($values);
    }

    /**
     * Add VALUES
     *
     * @param $values
     *
     * @return Insert
     * @throws Exception
     */
    public function values($values)
    {
        if (!is_array($values)) {
            throw new Exception('Param VALUES for INSERT query must be array');
        }

        $first = current($values);
        if (is_string(key($values))) {
            // is one row array
            $this->addOneValue($values);
        } elseif (is_array($first) && is_string(key($first))) {
            // this is multi values
            foreach ($values as $oneValue) {
                $this->addOneValue($oneValue);
            }
        }

        return $this;
    }

    /**
     * @param array $oneValue
     *
     * @throws Exception
     */
    private function addOneValue($oneValue)
    {
        // check if all $keys are strings
        foreach ($oneValue as $key => $value) {
            if (!is_string($key)) {
                throw new Exception('INSERT query: All keys of value array have to be strings.');
            }
        }
        if (!$this->firstValue) {
            $this->firstValue = $oneValue;
        }
        if (!$this->columns) {
            $this->columns = array_keys($oneValue);
        }
        if ($this->columns != array_keys($oneValue)) {
            throw new Exception('INSERT query: All VALUES have to same keys (columns).');
        }
        $this->statements['VALUES'][] = $oneValue;
    }

    /**
     * Force insert operation to fail silently
     *
     * @return Insert
     */
    public function ignore()
    {
        $this->ignore = true;

        return $this;
    }

    /** Force insert operation delay support
     *
     * @return Insert
     */
    public function delayed()
    {
        $this->delayed = true;

        return $this;
    }

    /**
     * Add ON DUPLICATE KEY UPDATE
     *
     * @param array $values
     *
     * @return Insert
     */
    public function onDuplicateKeyUpdate($values)
    {
        $this->statements['ON DUPLICATE KEY UPDATE'] = array_merge(
            $this->statements['ON DUPLICATE KEY UPDATE'],
            $values
        );

        return $this;
    }

    /**
     * Execute insert query
     *
     * @param mixed $sequence
     *
     * @throws Exception
     *
     * @return int|bool - Last inserted primary key
     */
    public function execute($sequence = null)
    {
        $result = parent::execute();

        if ($result) {
            return $this->fluent->getPdo()->lastInsertId($sequence);
        }

        return false;
    }

    /**
     * @param null $sequence
     *
     * @throws Exception
     *
     * @return bool
     */
    public function executeWithoutId($sequence = null)
    {
        $result = parent::execute();

        if ($result) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getClauseInsertInto()
    {
        return 'INSERT' .
            ($this->ignore ? " IGNORE" : '') .
            ($this->delayed ? " DELAYED" : '') .
            ' INTO ' .
            $this->statements['INSERT INTO'];
    }

    /**
     * @return string
     */
    protected function getClauseValues()
    {
        $valuesArray = [];
        foreach ($this->statements['VALUES'] as $rows) {
            // literals should not be parametrized.
            // They are commonly used to call engine functions or literals.
            // Eg: NOW(), CURRENT_TIMESTAMP etc
            $placeholders = array_map([$this, 'parameterGetValue'], $rows);
            $valuesArray[] = '(' . implode(', ', $placeholders) . ')';
        }

        $columns = implode(', ', $this->columns);
        $values = implode(', ', $valuesArray);

        return " ($columns) VALUES $values";
    }

    /**
     * @return string
     */
    protected function getClauseOnDuplicateKeyUpdate()
    {
        $result = [];
        foreach ($this->statements['ON DUPLICATE KEY UPDATE'] as $key => $value) {
            $result[] = "$key = " . $this->parameterGetValue($value);
        }

        return ' ON DUPLICATE KEY UPDATE ' . implode(', ', $result);
    }

    /**
     * @param $param
     *
     * @return string
     */
    protected function parameterGetValue($param)
    {
        return $param instanceof Literal ? (string)$param : '?';
    }

    /**
     * @return array
     */
    protected function buildParameters(): array
    {
        $this->parameters = array_merge(
            $this->filterLiterals($this->statements['VALUES']),
            $this->filterLiterals($this->statements['ON DUPLICATE KEY UPDATE'])
        );

        return parent::buildParameters();
    }

    /**
     * Removes all Literal instances from the argument
     * since they are not to be used as PDO parameters but rather injected directly into the query
     *
     * @param $statements
     *
     * @return array
     */
    protected function filterLiterals($statements)
    {
        $f = function ($item) {
            return !$item instanceof Literal;
        };

        return array_map(function ($item) use ($f) {
            if (is_array($item)) {
                return array_filter($item, $f);
            }

            return $item;
        }, array_filter($statements, $f));
    }
}
