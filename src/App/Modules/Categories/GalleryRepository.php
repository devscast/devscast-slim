<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Repositories;

use App\Entities\GalleryEntity;
use App\Modules;
use Framework\Repositories\Repository;

/**
 * Class GalleryRepository
 * Abstraction for the gallery table
 * @package App\Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class GalleryRepository extends Repository
{

    /**
     * The table name in the database
     * @var string
     */
    protected $table = Modules::GALLERY;

    /**
     * Entity class
     * @var GalleryEntity
     */
    protected $entity = GalleryEntity::class;
}
