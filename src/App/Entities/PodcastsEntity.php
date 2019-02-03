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
     * retrieve validation rules for an entity
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (empty(self::$validationRules)) {
            self::$validationRules = [
                'name' => v::notEmpty()->setName('Name'),
                'slug' => v::optional(v::alnum())->setName('Slug'),
                'description' => v::notEmpty()->notBlank()->setName('Description'),
                'duration' => v::notEmpty()->alnum(':')->setName('Durantion'),
                'thumb' => v::notEmpty()->setName('Thumb Cover'),
                'audio' => v::notEmpty()->setName('Audio'),
                'categories_id' => v::numeric()->setName('Categories Id'),
                'users_id' => v::numeric()->setName('Users Id')
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
        if(empty(self::$updateValidationRules)) {
            self::$updateValidationRules = [
                'name' => v::notEmpty()->setName('Name'),
                'slug' => v::optional(v::alnum())->setName('Slug'),
                'description' => v::optional(v::notEmpty()->notBlank())->setName('Description'),
                'categories_id' => v::optional(v::numeric())->setName('Categories Id'),
            ];
        }
        return self::$updateValidationRules;
    }
}
