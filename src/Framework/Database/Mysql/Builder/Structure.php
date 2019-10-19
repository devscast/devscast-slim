<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql\Builder;

/**
 * Class Structure
 * @package Framework\Database\Builder
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Structure
{

    /** @var string */
    private $primaryKey;

    /** @var string */
    private $foreignKey;

    /**
     * Structure constructor
     *
     * @param string $primaryKey
     * @param string $foreignKey
     */
    public function __construct($primaryKey = 'id', $foreignKey = '%s_id')
    {
        if ($foreignKey === null) {
            $foreignKey = $primaryKey;
        }
        $this->primaryKey = $primaryKey;
        $this->foreignKey = $foreignKey;
    }

    /**
     * @param string $table
     *
     * @return string
     */
    public function getPrimaryKey($table)
    {
        return $this->key($this->primaryKey, $table);
    }

    /**
     * @param string $table
     *
     * @return string
     */
    public function getForeignKey($table)
    {
        return $this->key($this->foreignKey, $table);
    }

    /**
     * @param string|callback $key
     * @param string          $table
     *
     * @return string
     */
    private function key($key, $table)
    {
        if (is_callable($key)) {
            return $key($table);
        }

        return sprintf($key, $table);
    }
}
