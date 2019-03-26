<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace App\Validators;


use Core\Repositories\ValidatorInterface;
use Respect\Validation\Validator as v;

/**
 * Class PodcastLinksValidator
 * @package App\Validators
 */
abstract class PodcastLinksValidator implements ValidatorInterface
{

    /**
     * @var array
     */
    private static $updateAbleFields = ['reference', 'description'];

    /**
     * @var array
     */
    private static $storeAbleFields = ['reference', 'podcasts_id', 'description'];

    /**
     * @var array
     */
    private static $validationRules;

    /**
     * @var array
     */
    private static $updateValidationRules;

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (empty(self::$validationRules)) {
            self::$validationRules = [
                'reference' => v::notEmpty()->setName('Reference'),
                'description' => v::notEmpty()->setName('Description')
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
                'reference' => v::notEmpty()->setName('Reference'),
                'description' => v::notEmpty()->setName('Description')
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
            self::$storeAbleFields = array_keys(self::getUpdateAbleFields());
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
            self::$updateAbleFields = array_keys(self::getUpdateAbleFields());
        }
        return self::$updateAbleFields;
    }
}