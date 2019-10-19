<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Podcast\Category;

use Respect\Validation\Validator as v;

/**
 * Class CategoriesValidator
 * @package Modules\Podcast\Category
 * @author bernard-ng <ngandubernard@gmail.com>
 */
abstract class CategoriesValidator
{

    /**
     * List of fields that can be stored in the Repository
     *
     * @var array
     */
    private static $createFields = ['name', 'slug', 'description'];

    /**
     * List of fields that can be updated in the Repository
     *
     * @var array
     */
    private static $updateFields = ['name', 'slug', 'description'];

    /**
     * Retrieve validation rules
     *
     * @return array
     */
    public static function getCreateRules(): array
    {
        return [
            'name' => v::notEmpty()->setName('Name'),
            'slug' => v::optional(v::slug())->setName('Slug'),
            'description' => v::notEmpty()->notBlank()->setName('Description'),
        ];
    }

    /**
     * Retrieve update validation rules
     *
     * @return array
     */
    public static function getUpdateRules(): array
    {
        return [
            'name' => v::optional(v::notEmpty()->setName('Name')),
            'slug' => v::optional(v::slug())->setName('Slug'),
            'description' => v::optional(v::notEmpty()->notBlank()->setName('Description')),
        ];
    }
}
