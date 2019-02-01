<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repositories;

use App\Entities\CategoriesEntity;
use Core\Repository;

/**
 * Class CategoriesRepository
 * @package App\Repositories
 */
class CategoriesRepository extends Repository
{

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table = 'categories';


    /**
     * the class that represents one category
     * @var CategoriesEntity
     */
    protected $entity = CategoriesEntity::class;
}
