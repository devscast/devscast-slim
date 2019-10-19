<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql;

use Framework\Logger;
use PDO;
use Exception;
use PDOException;
use Psr\Container\ContainerInterface;

/**
 * Class MysqlPDOFactory
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Database\Mysql
 */
class MysqlPDOFactory
{

    /**
     * @var PDO
     */
    private $instance = null;

    /**
     * @param ContainerInterface $container
     * @return PDO
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    public function __invoke(ContainerInterface $container): PDO
    {
        if (is_null($this->instance)) {
            [$host, $name, $username, $password] = [
                $container->get('database.host'),
                $container->get('database.name'),
                $container->get('database.username'),
                $container->get('database.password')
            ];

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
            ];

            try {
                $pdo = new PDO("mysql:Host={$host};dbname={$name}", $username, $password, $options);
                $this->instance = $pdo;
            } catch (PDOException | Exception $e) {
                Logger::error($e->getMessage(), [$e->getTraceAsString()]);
                return null;
            }
        }
        return $this->instance;
    }
}
