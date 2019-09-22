<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App;

/**
 * Class AbstractValidator
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 */
abstract class AbstractValidator
{

    /**
     * Retrieve validation rules
     *
     * @return array
     */
    abstract public static function getValidationRules(): array;

    /**
     * Retrieve update validation rules
     *
     * @return array
     */
    abstract public static function getUpdateValidationRules(): array;

    /**
     * Retrieve the list of storeable fields
     *
     * @return array
     */
    abstract public static function getStoreAbleFields(): array;

    /**
     * Retrieve the list of updateable fields
     *
     * @return array
     */
    abstract public static function getUpdateAbleFields(): array;
}
