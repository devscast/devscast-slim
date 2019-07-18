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

use App\Entities\PodcastLinksEntity;
use App\Modules;
use Core\Database\Builder\Exception;
use Core\Repositories\Repository;

/**
 * Class PodcastLinksRepository
 * @package App\Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PodcastLinksRepository extends Repository
{

    /**
     * The table name in the database
     * @var string
     */
    protected $table = Modules::PODCASTLINKS_TABLE;

    /**
     * Entity class
     * @var PodcastLinksEntity
     */
    protected $entity = PodcastLinksEntity::class;

    /**
     * Retrieve all podcastLinks for a specific podcast
     * @param int $id
     * @return Object|array|mixed
     */
    public function get(int $id)
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select("{$this->table}.*")
                ->where("podcasts_id = ?", compact('id'))
                ->orderBy("{$this->table}.reference ASC")
                ->all()->get();
        } catch (Exception $e) {
            return null;
        }
    }
}
