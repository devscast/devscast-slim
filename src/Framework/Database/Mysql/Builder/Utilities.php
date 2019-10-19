<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql\Builder;

use Countable;
use PDOStatement;
use Traversable;

/**
 * Class Utilities
 * @package Framework\Database\Builder
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Utilities
{
    /**
     * Convert "camelCaseWord" to "CAMEL CASE WORD"
     *
     * @param string $string
     *
     * @return string
     */
    public static function toUpperWords($string)
    {
        $regex = new Regex();
        return trim(strtoupper($regex->camelCaseSpaced($string)));
    }

    /**
     * @param string $query
     *
     * @return string
     */
    public static function formatQuery($query)
    {
        $regex = new Regex();

        $query = $regex->splitClauses($query);
        $query = $regex->splitSubClauses($query);
        $query = $regex->removeLineEndWhitespace($query);

        return $query;
    }

    /**
     * Converts columns from strings to types according to PDOStatement::columnMeta()
     *
     * @param PDOStatement      $statement
     * @param array|Traversable $rows - provided by PDOStatement::fetch with PDO::FETCH_ASSOC
     *
     * @return array|Traversable
     */
    public static function stringToNumeric(PDOStatement $statement, $rows)
    {
        for ($i = 0; ($columnMeta = $statement->getColumnMeta($i)) !== false; $i++) {
            $type = $columnMeta['native_type'];

            switch ($type) {
                case 'DECIMAL':
                case 'DOUBLE':
                case 'FLOAT':
                case 'INT24':
                case 'LONG':
                case 'LONGLONG':
                case 'NEWDECIMAL':
                case 'SHORT':
                case 'TINY':
                    if (isset($rows[$columnMeta['name']])) {
                        $rows[$columnMeta['name']] = $rows[$columnMeta['name']] + 0;
                    } else {
                        if (is_array($rows) || $rows instanceof Traversable) {
                            foreach ($rows as &$row) {
                                if (isset($row[$columnMeta['name']])) {
                                    $row[$columnMeta['name']] = $row[$columnMeta['name']] + 0;
                                }
                            }
                        }
                    }
                    break;
                default:
                    // return as string
                    break;
            }
        }

        return $rows;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public static function convertSqlWriteValues($value)
    {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = self::convertValue($v);
            }
        } else {
            $value = self::convertValue($value);
        }

        return $value;
    }

    /**
     * @param $value
     *
     * @return int|string
     */
    public static function convertValue($value)
    {
        switch (gettype($value)) {
            case 'boolean':
                $conversion = ($value) ? 1 : 0;
                break;
            default:
                $conversion = $value;
                break;
        }

        return $conversion;
    }

    /**
     * @param $subject
     *
     * @return bool
     */
    public static function isCountable($subject)
    {
        return (is_array($subject) || ($subject instanceof Countable));
    }

    /**
     * @param $value
     *
     * @return Literal|mixed
     */
    public static function nullToLiteral($value)
    {
        if ($value === null) {
            return new Literal('NULL');
        }

        return $value;
    }
}
