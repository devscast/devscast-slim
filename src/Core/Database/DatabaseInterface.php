<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
