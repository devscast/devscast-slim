<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Repositories\Validators;


use Core\Repositories\ValidatorInterface;
use Respect\Validation\Validator as v;

/**
 * Class CategoriesValidator
 * @package App\Repositories\Validators
 */
class CategoriesValidator implements ValidatorInterface
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
            self::$validationRules = [
                'name' => v::notEmpty()->setName('Name'),
                'slug' => v::optional(v::slug())->setName('Slug'),
                'description' => v::notEmpty()->notBlank()->setName('Description'),
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