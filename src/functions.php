<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

if (!function_exists('evalBool')) {
    /**
     * parse a string and return its boolean value
     *
     * @param $value
     * @return bool
     * @author bernard-ng <ngandubernard@gmail.com>
     */
    function evalBool($value): bool
    {
        return (strcasecmp($value, 'true') ? false : true);
    }
}
