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
 * Class Hydrator
 * Hydrate an object with data coming from an array
 * @package Core\Database
 * @author bernard-ng, https://bernard-ng.github.io
 */
abstract class Hydrator
{

    /**
     * Hydrate an object with data coming from an array
     * @param array $data
     * @param $object
     * @return mixed
     */
    public static function hydrate(array $data, $object)
    {
        $instance = new $object();

        foreach ($data as $key => $datum) {
            $method = self::getSetter($key);
            if (method_exists($instance, $method)) {
                $instance->$method($datum);
            } else {
                $property = lcfirst(self::getProperty($key));
                $instance->$property = $datum;
            }
        }
        return $instance;
    }


    /**
     * Generate setter for all property
     * create_at => setCreateAt
     * @param string $field
     * @return string
     */
    private static function getSetter(string $field): string
    {
        return "set". self::getProperty($field);
    }

    /**
     * Transforms a snake case to PascalCase
     * create_at => CreateAt
     * @param string $field
     * @return string
     */
    private static function getProperty(string $field): string
    {
        return join('', array_map('ucfirst', explode('_', $field)));
    }
}
