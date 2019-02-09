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

use App\Entities\GalleryEntity;
use Core\Repositories\Repository;

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
    protected $table = 'gallery';

    /**
     * Entity class
     * @var GalleryEntity
     */
    protected $entity = GalleryEntity::class;
}
