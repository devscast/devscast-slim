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
 * Class NewsletterEntity
 * @package App\Entities
 */
class NewsletterEntity
{
    /**
     * validation rules
     * @var array
     */
    public static $validationRules = [];


    /**
     * retrieve validation rules for an entity
     * @return array
     */
    public static function getValidationRules(): array
    {
        self::$validationRules = [
            'email' => v::notEmpty()->email()
        ];
        return self::$validationRules;
    }
}
