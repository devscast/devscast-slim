<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Framework\Database;

use PDO;
use Exception;
use Framework\Logger;
use PDOException;
use Psr\Container\ContainerInterface;

/**
 * Class PDOFactory
 * \PDO::class factory
 * @see \PDO
 * @package Framework\Database
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PDOFactory
{

    /**
     * @var null|PDO
     */
    private $PDO = null;


    /**
     * @param ContainerInterface $container
     * @return PDO
     * @internal param string $host
     * @internal param string $dbname
     * @internal param string $username
     * @internal param string $password
     */
    public function __invoke(ContainerInterface $container): PDO
    {
        if (is_null($this->PDO)) {
            $host = $container->get('database.host');
            $dbname = $container->get('database.name');
            $username = $container->get('database.username');
            $password = $container->get('database.password');

            try {
                $attribute = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
                ];

                $PDO = new PDO("mysql:Host={$host};dbname={$dbname};charset=utf8", $username, $password, $attribute);
                $this->PDO = $PDO;
                return $this->PDO;
            } catch (PDOException | Exception $e) {
                Logger::error($e->getMessage(), [$e->getTraceAsString()]);
                exit();
            }
        }
        return $this->PDO;
    }
}
