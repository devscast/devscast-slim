<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entities;

use Respect\Validation\Validator as v;

/**
 * Class PodcastsEntity
 * @package App\Entities
 */
class PodcastsEntity
{
    /**
     * validation rules
     * @var array
     */
    private static $validationRules = [];

    /**
     * validation rules when there is an update
     * @var array
     */
    private static $updateValidationRules = [];

    /**
     * fields in the entity that can be store
     * @var array
     */
    private static $storeAbleFields = [];

    /**
     * fields in the entity that can be update
     * @var array
     */
    private static $updateAbleFields = [];
    
    /**
     * retrieve validation rules for an entity
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (empty(self::$validationRules)) {
            self::$validationRules = [
                'name' => v::notEmpty()->setName('Name'),
                'slug' => v::optional(v::slug())->setName('Slug'),
                'description' => v::notEmpty()->notBlank()->setName('Description'),
                'duration' => v::notEmpty()->alnum(':')->setName('Durantion'),
                'categories_id' => v::notEmpty()->numeric()->setName('Categories Id'),
                'users_id' => v::notEmpty()->numeric()->setName('Users Id')
            ];
        }
        return self::$validationRules;
    }

    /**
     * retrieve update validation rules for an entity
     * @return array
     */
    public static function getUpdateValidationRules(): array
    {
        if (empty(self::$updateValidationRules)) {
            self::$updateValidationRules = [
                'name' => v::notEmpty()->setName('Name'),
                'slug' => v::optional(v::slug())->setName('Slug'),
                'description' => v::notEmpty()->notBlank()->setName('Description'),
                'categories_id' => v::notEmpty()->numeric()->setName('Categories Id'),
            ];
        }
        return self::$updateValidationRules;
    }

    /**
     * retrieve store able fields
     * @return array
     */
    public static function getStoreAbleFields(): array
    {
        if (empty(self::$storeAbleFields)) {
            self::$storeAbleFields = array_keys(self::getValidationRules());
        }
         return self::$storeAbleFields;
    }

    /**
     * retrieve update able fields
     * @return array
     */
    public static function getUpdateAbleFields(): array
    {
        if (empty(self::$updateAbleFields)) {
            self::$updateAbleFields = array_keys(self::getUpdateValidationRules());
        }
        return self::$updateAbleFields;
    }
}
