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

/**
 * Class GalleryValidator
 * @package App\Validators
 * @author bernard-ng, https://bernard-ng.github.io
 */
abstract class GalleryValidator implements ValidatorInterface
{

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array
    {
        // TODO: Implement getValidationRules() method.
    }

    /**
     * Retrieve update validation rules
     * @return array
     */
    public static function getUpdateValidationRules(): array
    {
        // TODO: Implement getUpdateValidationRules() method.
    }

    /**
     * Retrieve the list of storeable fields
     * @return array
     */
    public static function getStoreAbleFields(): array
    {
        // TODO: Implement getStoreAbleFields() method.
    }

    /**
     * Retrieve the list of updateable fields
     * @return array
     */
    public static function getUpdateAbleFields(): array
    {
        // TODO: Implement getUpdateAbleFields() method.
    }
}
