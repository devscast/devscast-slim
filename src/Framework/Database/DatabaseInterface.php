<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database;

/**
 * Interface DatabaseInterface
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Database
 */
interface DatabaseInterface
{

    /**
     * get database connexion
     * @return object
     */
    public function getConnexion(): object;
}
