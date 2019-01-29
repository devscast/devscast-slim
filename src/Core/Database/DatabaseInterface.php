<?php
namespace App\Database;

/**
 * Interface DatabaseInterface
 * @package App\Database
 */
interface DatabaseInterface
{

    /**
     * DatabaseInterface constructor.
     * @param string $name
     * @param string $host
     * @param string $user
     * @param string $pass
     */
    public function __construct(string $name, string $host, string $user, string $pass);
}
