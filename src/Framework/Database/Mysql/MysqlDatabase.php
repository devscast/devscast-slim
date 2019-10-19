<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql;

use PDO;
use Framework\Database\DatabaseInterface;

/**
 * Class MysqlDatabase
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Database\Mysql
 */
class MysqlDatabase implements DatabaseInterface
{

    /** @var PDO */
    private $PDO;

    /**
     * MysqlDatabase constructor.
     * @param PDO $PDO
     */
    public function __construct(PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    /**
     * get database connexion
     * @return object
     */
    public function getConnexion(): object
    {
        return $this->PDO;
    }
}
