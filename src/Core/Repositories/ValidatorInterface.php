<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Core\Repositories;


/**
 * Interface RepositoryValidatorInterface
 * @package App\Repositories\Validators
 */
interface ValidatorInterface
{

    /**
     * retrieve validation rules for an entity
     * @return array
     */
    public static function getValidationRules(): array;

    /**
     * retrieve update validation rules for an entity
     * @return array
     */
    public static function getUpdateValidationRules(): array;

    /**
     * retrieve store able fields
     * @return array
     */
    public static function getStoreAbleFields(): array;

    /**
     * retrieve update able fields
     * @return array
     */
    public static function getUpdateAbleFields(): array;
}
