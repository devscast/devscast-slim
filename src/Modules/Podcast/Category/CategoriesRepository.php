<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Podcast\Category;

use App\Enumerations\TablesEnum;
use Framework\Database\AbstractRepository;

/**
 * Class CategoriesRepository
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Modules\Category
 */
class CategoriesRepository extends AbstractRepository
{

    /**
     * The table name in the database
     *
     * @var string
     */
    protected $table = TablesEnum::CATEGORIES;


    /**
     * Entity class
     *
     * @var CategoriesEntity
     */
    protected $entity = CategoriesEntity::class;
}
