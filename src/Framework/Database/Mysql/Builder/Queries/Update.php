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
use PDOStatement;

/**
 * Class Update
 * UPDATE query builder
 * @package Framework\Database\Builder\Queries
 * @method Update  leftJoin(string $statement) add LEFT JOIN to query
 *                        ($statement can be 'table' name only or 'table:' means back reference)
 * @method Update  innerJoin(string $statement) add INNER JOIN to query
 *                        ($statement can be 'table' name only or 'table:' means back reference)
 * @method Update  orderBy(string $column) add ORDER BY to query
 * @method Update  limit(int $limit) add LIMIT to query
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Update extends Common
{

    /**
     * UpdateQuery constructor
     *
     * @param Query  $fluent
     * @param string $table
     */
    public function __construct(Query $fluent, string $table)
    {
        $clauses = [
            'UPDATE'   => [$this, 'getClauseUpdate'],
            'JOIN'     => [$this, 'getClauseJoin'],
            'SET'      => [$this, 'getClauseSet'],
            'WHERE'    => [$this, 'getClauseWhere'],
            'ORDER BY' => ', ',
            'LIMIT'    => null,
        ];
        parent::__construct($fluent, $clauses);

        $this->statements['UPDATE'] = $table;

        $tableParts = explode(' ', $table);
        $this->joins[] = end($tableParts);
    }

    /**
     * In Update's case, parameters are not assigned until the query is built, since this method
     *
     * @param string|array $fieldOrArray
     * @param bool|string  $value
     *
     * @throws Exception
     *
     * @return $this
     */
    public function set($fieldOrArray, $value = false)
    {
        if (!$fieldOrArray) {
            return $this;
        }
        if (is_string($fieldOrArray) && $value !== false) {
            $this->statements['SET'][$fieldOrArray] = $value;
        } else {
            if (!is_array($fieldOrArray)) {
                throw new Exception(
                    'You must pass a value, or provide the SET list as an associative array. column => value'
                );
            } else {
                foreach ($fieldOrArray as $field => $value) {
                    $this->statements['SET'][$field] = $value;
                }
            }
        }

        return $this;
    }

    /**
     * Execute update query
     *
     * @param boolean $getResultAsPdoStatement true to return the pdo statement instead of row count
     *
     * @return int|boolean|PDOStatement
     *@throws Exception
     *
     */
    public function execute($getResultAsPdoStatement = false)
    {
        if (empty($this->statements['WHERE'])) {
            throw new Exception('Update queries must contain a WHERE clause to prevent unwanted data loss');
        }

        $result = parent::execute();

        if ($getResultAsPdoStatement) {
            return $result;
        }

        if ($result) {
            return $result->rowCount();
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getClauseUpdate()
    {
        return 'UPDATE ' . $this->statements['UPDATE'];
    }

    /**
     * @return string
     */
    protected function getClauseSet()
    {
        $setArray = [];
        foreach ($this->statements['SET'] as $field => $value) {
            // named params are being used here
            if (is_array($value) && strpos(key($value), ':') === 0) {
                $key = key($value);
                $setArray[] = $field . ' = ' . $key;
                $this->parameters['SET'][$key] = $value[$key];
            } elseif ($value instanceof Literal) {
                $setArray[] = $field . ' = ' . $value;
            } else {
                $setArray[] = $field . ' = ?';
                $this->parameters['SET'][$field] = $value;
            }
        }

        return ' SET ' . implode(', ', $setArray);
    }
}
