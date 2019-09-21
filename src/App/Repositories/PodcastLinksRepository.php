<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Repositories;

use App\Entities\PodcastLinksEntity;
use App\Modules;
use Framework\Database\Builder\Exception;
use Framework\Repositories\Repository;
use Framework\Logger;

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
     * @var string
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
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }
}
