<?php
namespace App\Repositories;

use App\Entities\PodcastLinksEntity;
use Core\Repository;

/**
 * Class PodcastLinksRepository
 * @package App\Repositories
 */
class PodcastLinksRepository extends Repository
{

    /**
     * @inheritDoc
     * @var string
     */
    protected $table = 'podcast_links';

    /**
     * represents one podcast link
     * @var PodcastLinksEntity
     */
    protected $entity = PodcastLinksEntity::class;
}
