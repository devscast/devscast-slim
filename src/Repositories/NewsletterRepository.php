<?php
namespace App\Repositories;
use App\Entities\NewsletterEntity;

/**
 * Class NewsletterRepository
 * @package App\Repositories
 */
class NewsletterRepository extends Repository
{

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table = 'newsletter';


    /**
     * the class that represent one newsLetter instance
     * @var NewsletterEntity
     */
    protected $entity = NewsletterEntity::class;

}