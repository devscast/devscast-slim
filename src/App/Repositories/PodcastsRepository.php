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

use App\Entities\PodcastsEntity;
use Core\Database\Builder\Queries\Select;
use Core\Database\Builder\Query;
use Core\Repositories\Repository;

/**
 * Class PodcastsRepository
 * @package App\Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class PodcastsRepository extends Repository
{

    /**
     * The table name in the database
     * @var string
     */
    protected $table = 'podcasts';

    /**
     * Entity class
     * @var PodcastsEntity
     */
    protected $entity = PodcastsEntity::class;


    /**
     * Base query for fetching with category and user
     * @return Select
     */
    private function withCategoryaAndUser(): Select
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->select("categories.name AS category_name, categories.slug AS category_slug")
            ->select("users.name AS username")
            ->leftJoin("categories ON {$this->table}.categories_id = categories.id")
            ->leftJoin("users ON {$this->table}.users_id = users.id")
            ->orderBy("{$this->table}.id DESC");
    }

    /**
     * @inheritdoc
     * @return Object|array|mixed
     */
    public function all()
    {
        return $this->withCategoryaAndUser()->all()->get();
    }

    /**
     * Retrieve the latest podcasts
     * @param int $limit
     * @return Object|array|mixed
     */
    public function latest(int $limit)
    {
        return $this->withCategoryaAndUser()->limit($limit)->all()->get();
    }

    /**
     * Retrieve the last podcast
     * @return Object|array|mixed
     */
    public function last()
    {
        return $this->withCategoryaAndUser()->limit(1)->all()->get(0);
    }

    /**
     * Retrieve one podcast thanks to an 'id'
     * @param int $id
     * @return Object|array|mixed
     */
    public function find(int $id)
    {
        return $this->withCategoryaAndUser()
            ->where("{$this->table}.id", compact('id'))
            ->all()->get(0);
    }

    /**
     * Retrieve a podcast with specific conditions
     * @param string $field
     * @param $value
     * @return Object|array|mixed
     */
    public function findWith(string $field, $value)
    {
        return $this->withCategoryaAndUser()
            ->where("{$this->table}.{$field} = ?", [$field => $value])
            ->all()->get();
    }


    /**
     * Base Query for singlePagination
     * @return Select
     */
    private function singlePagination()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select(["{$this->table}.name", "{$this->table}.slug", "{$this->table}.id"])
            ->limit(1);
    }

    /**
     * Retrieve the next record
     * @param $id
     * @return Object|array|mixed
     */
    public function next($id)
    {
        return $this->singlePagination()
            ->where("{$this->table}.id > ?", compact('id'))
            ->orderBy("{$this->table}.id ASC")
            ->all()->get(0);
    }

    /**
     * Retrieve the previous record
     * @param $id
     * @return Object|array|mixed
     */
    public function previous($id)
    {
        return $this->singlePagination()
            ->where("{$this->table}.id < ?", compact('id'))
            ->orderBy("{$this->table}.id DESC")
            ->all()->get(0);
    }
}
