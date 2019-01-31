<?php
namespace App\Repositories;


use Core\Repository;

/**
 * Class PodcastLinksRepository
 * @package App\Repositories
 */
class PodcastLinksRepository extends Repository
{

    protected $table = 'podcast_links';

    protected $entity;
}