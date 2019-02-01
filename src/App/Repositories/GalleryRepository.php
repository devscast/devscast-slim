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
