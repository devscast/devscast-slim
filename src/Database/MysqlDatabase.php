<?php

namespace App\Database;

use PDO;
use PDOException;

/**
 * Class MysqlDatabase
 * @package App\Database
 */
class MysqlDatabase implements DatabaseInterface
{

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * MysqlDatabase constructor.
     * @param string $name
     * @param string $host
     * @param string $user
     * @param string $pass
     */
    public function __construct(string $name, string $host, string $user, string $pass)
    {
        try {
            $this->pdo = new PDO("mysql:Host={$host};dbname={$name}", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

            return $this->pdo;
        } catch (\Exception $e) {
            var_dump($e);
        }
    }
    

    /**
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @param string $statement
     * @param array $data
     * @param string $entity
     * @param boolean $fetchAll
     * @return array|mixed|\PDOStatement
     */
    public function prepare(string $statement, array $data, ?string $entity = null, bool $fetchAll = true)
    {
        try {
            $req = $this->pdo->prepare($statement);
            $req->execute($data);

            if ($this->needsFetch($statement)) {
                (is_null($entity)) ?
                    $req->setFetchMode(PDO::FETCH_OBJ) :
                    $req->setFetchMode(PDO::FETCH_CLASS, $entity);

                return ($fetchAll) ? $req->fetchAll() : $req->fetch();
            } else {
                return $req;
            }
        } catch (PDOException $e) {
            die($e);
        }
    }

    /**
     * tells if the query needs to fetch data
     * @param string $statement
     * @return boolean
     */
    private function needsFetch(string $statement): bool
    {
        $statement = trim($statement);
        switch ($statement) {
            case strpos($statement, 'INSERT') === 0:
                return false;
                break;
            case strpos($statement, 'UPDATE') === 0:
                return false;
                break;
            case strpos($statement, 'DELETE') === 0:
                return false;
                break;
            default:
                return true;
                break;
        }
    }

    /**
     * @param string $statement
     * @param string $entity
     * @param boolean $fetchAll
     * @return array|mixed|\PDOStatement
     */
    public function query(string $statement, ?string $entity, bool $fetchAll)
    {
        try {
            $req = $this->pdo->query($statement);
            if ($this->needsFetch($statement)) {
                (is_null($entity)) ?
                    $req->setFetchMode(PDO::FETCH_OBJ) :
                    $req->setFetchMode(PDO::FETCH_CLASS, $entity);

                return ($fetchAll) ? $req->fetchAll() : $req->fetch();
            } else {
                return $req;
            }
        } catch (PDOException $e) {
            die($e);
        }
    }
}
