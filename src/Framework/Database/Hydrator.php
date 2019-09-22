<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database;

/**
 * Class Hydrator
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework\Database
 */
abstract class Hydrator
{

    public static function hydrate(array $data, $entity)
    {
        $instance = new $entity();

        foreach ($data as $property => $value) {
            $setter = self::getSetter($property);
            if (method_exists($instance, $setter)) {
                $instance->$setter($value);
            } else {
                $property = lcfirst(self::getProperty($property));
                $instance->$property = $value;
            }
        }

        return $instance;
    }

    /**
     * get the setter for a property
     *
     * @param string $field
     * @return string
     */
    private static function getSetter(string $field): string
    {
        return "set" . self::getProperty($field);
    }

    /**
     * transforms a snake case to PascalCase
     *  Ex: created_at => CreatedAt
     *
     * @param string $field
     * @return string
     */
    private static function getProperty(string $field): string
    {
        return join('', array_map('ucfirst', explode('_', $field)));
    }
}
