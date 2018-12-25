<?php
namespace App\Repositories;

use App\Entities\CategoriesEntity;

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