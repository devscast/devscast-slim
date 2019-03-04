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
 * Describe how Repository Validators should work
 * @package App\Repositories\Validators
 * @author bernard-ng, https://bernard-ng.github.io
 */
interface ValidatorInterface
{

    /**
     * Retrieve validation rules
     * @return array
     */
    public static function getValidationRules(): array;

    /**
     * Retrieve update validation rules
     * @return array
     */
    public static function getUpdateValidationRules(): array;

    /**
     * Retrieve the list of storeable fields
     * @return array
     */
    public static function getStoreAbleFields(): array;

    /**
     * Retrieve the list of updateable fields
     * @return array
     */
    public static function getUpdateAbleFields(): array;
}
