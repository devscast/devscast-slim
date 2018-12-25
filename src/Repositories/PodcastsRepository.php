<?php
namespace App\Repositories;

use App\Entities\PodcastsEntity;


/**
 * Class PodcastsRepository
 * @package App\Repositories
 */
class PodcastsRepository extends Repository
{

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table = 'podcasts';

    /**
     * the class that represents one podcast
     * @var PodcastsEntity
     */
    protected $entity = PodcastsEntity::class;
}