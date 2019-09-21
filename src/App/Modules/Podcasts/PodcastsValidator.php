<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Validators;

use Framework\Repositories\ValidatorInterface;
use Respect\Validation\Validator as v;

/**
 * Class PodcastsValidator
 * Implementation for podcasts
 * @package App\Repositories\Validators
 * @author bernard-ng, https://bernard-ng.github.io
 */
abstract class PodcastsValidator implements ValidatorInterface
{
    /**
     * Validation rules
     * @var array
     */
    private static $validationRules = [];

    /**
     * Validation rules when there is an update
     * @var array
     */
    private static $updateValidationRules = [];

    /**
     * List of fields that can be stored in the Repository
     * @var array
     */
    private static $storeAbleFields = [];

    /**
     * List of fields that can be stored in the Repository
     * @var array
     */
    private static $updateAbleFields = [];

    /**
     * Retrieve validation rules
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
     * Retrieve update validation rules
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
                'online' => v::optional(v::notBlank())->setName('online'),
            ];
        }
        return self::$updateValidationRules;
    }

    /**
     * Retrieve the list of storeable fields
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
     * Retrieve the list of updateable fields
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
