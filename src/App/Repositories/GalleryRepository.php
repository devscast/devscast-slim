<?php
namespace App\Repositories;

use App\Entities\GalleryEntity;
use Core\Repository;

/**
 * Class GalleryRepository
 * @package App\Repositories
 */
class GalleryRepository extends Repository
{

    /**
     * @inheritDoc
     * @var string
     */
    protected $table = 'gallery';

    /**
     * represents one gallery item
     * @var GalleryEntity
     */
    protected $entity = GalleryEntity::class;
}
