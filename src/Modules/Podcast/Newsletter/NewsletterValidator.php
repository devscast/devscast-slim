<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Podcast\Newsletter;

use App\AbstractValidator;
use Respect\Validation\Validator as v;

/**
 * Class NewsletterValidator
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Validators
 */
abstract class NewsletterValidator extends AbstractValidator
{
    /**
     * Validation rules
     *
     * @var array
     */
    private static $validationRules = [];

    /**
     * Validation rules when there is an update
     *
     * @var array
     */
    private static $updateValidationRules = [];

    /**
     * List of fields that can be stored in the Repository
     *
     * @var array
     */
    private static $storeAbleFields = [];

    /**
     * List of fields that can be updated in the Repository
     *
     * @var array
     */
    private static $updateAbleFields = [];

    /**
     * Retrieve validation rules
     *
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (empty(self::$validationRules)) {
            self::$validationRules = [
                'email' => v::notEmpty()->email()->setName('Email'),
            ];
        }
        return self::$validationRules;
    }

    /**
     * Retrieve update validation rules
     *
     * @return array
     */
    public static function getUpdateValidationRules(): array
    {
        if (empty(self::$updateValidationRules)) {
            self::$updateValidationRules = [
                'email' => v::notEmpty()->email()->setName('Email'),
            ];
        }
        return self::$updateValidationRules;
    }

    /**
     * Retrieve the list of storeable fields
     *
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
     *
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
