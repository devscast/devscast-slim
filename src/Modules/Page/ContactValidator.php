<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Page;

use App\AbstractValidator;
use Respect\Validation\Validator as v;

/**
 * Class ContactValidator
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Validators
 */
abstract class ContactValidator extends AbstractValidator
{

    /**
     * @var array
     */
    private static $validationRules;

    /**
     * @var array
     */
    private static $storeAbleFields = ['email', 'name', 'subject', 'message'];

    /**
     * Retrieve validation rules
     *
     * @return array
     */
    public static function getValidationRules(): array
    {
        if (is_null(self::$validationRules)) {
            self::$validationRules = [
                'email' => v::notEmpty()->email()->setName('Email'),
                'name' => v::notEmpty()->setName('Name'),
                'subject' => v::notEmpty()->setName('Subject'),
                'message' => v::notEmpty()->setName('Message')
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
        return [];
    }

    /**
     * Retrieve the list of storeable fields
     *
     * @return array
     */
    public static function getStoreAbleFields(): array
    {
        return self::$storeAbleFields;
    }

    /**
     * Retrieve the list of updateable fields
     *
     * @return array
     */
    public static function getUpdateAbleFields(): array
    {
        return [];
    }
}
