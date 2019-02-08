<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Database\Builder\Queries;

use Core\Database\Query;
use Core\Database\Utilities;

/**
 * Class Json
 *
 * @package Envms\FluentPDO\Queries
 */
class Json extends Common
{

    /** @var mixed */
    protected $fromTable;
    /** @var mixed */
    protected $fromAlias;
    /** @var boolean */
    protected $convertTypes = false;

    /**
     * Json constructor
     *
     * @param Query  $fluent
     * @param string $table
     */
    public function __construct(Query $fluent, string $table)
    {
        $clauses = [
            'SELECT'   => ', ',
            'JOIN'     => [$this, 'getClauseJoin'],
            'WHERE'    => [$this, 'getClauseWhere'],
            'GROUP BY' => ',',
            'HAVING'   => ' AND ',
            'ORDER BY' => ', ',
            'LIMIT'    => null,
            'OFFSET'   => null,
            "\n--"     => "\n--",
        ];

        parent::__construct($fluent, $clauses);

        // initialize statements
        $tableParts = explode(' ', $table);
        $this->fromTable = reset($tableParts);
        $this->fromAlias = end($tableParts);

        $this->statements['SELECT'][] = '';
        $this->joins[] = $this->fromAlias;

        if (isset($fluent->convertTypes) && $fluent->convertTypes) {
            $this->convertTypes = true;
        }
    }
}
