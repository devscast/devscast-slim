<?php
namespace Core\Database;

/**
 * Interface DatabaseInterface
 * @package Core\Database
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
