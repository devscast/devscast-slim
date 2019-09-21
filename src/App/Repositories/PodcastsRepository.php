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

use App\Modules;
use Framework\Logger;
use App\Entities\PodcastsEntity;
use Framework\Repositories\Repository;
use Framework\Database\Builder\Exception;
use Framework\Database\Builder\Queries\Select;

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
    protected $table = Modules::PODCASTS;

    /**
     * Entity class
     * @var string
     */
    protected $entity = PodcastsEntity::class;


    /**
     * Base query for fetching with category and user
     * @return Select
     * @throws Exception
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
     * @return Object|array|null
     */
    public function all()
    {
        try {
            return $this->withCategoryaAndUser()->all()->get();
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve online podcasts
     * @return null
     */
    public function allOnline()
    {
        try {
            return $this->withCategoryaAndUser()
                ->where("{$this->table}.online = 1")
                ->all()->get();
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve offline podcasts
     * @return null
     */
    public function allOffline()
    {
        try {
            return $this->withCategoryaAndUser()
                ->where("{$this->table}.online = 0")
                ->all()->get();
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve the latest podcasts
     * @param int $limit
     * @return Object|array|null
     */
    public function latest(int $limit)
    {
        try {
            return $this->withCategoryaAndUser()
                ->where("{$this->table}.online = 1")
                ->limit($limit)->all()->get();
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve the last podcast
     * @return Object|array|null
     */
    public function last()
    {
        try {
            return $this->withCategoryaAndUser()
                ->where("{$this->table}.online = 1")
                ->limit(1)->all()->get(0);
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve one podcast thanks to an 'id'
     * @param int $id
     * @return Object|array|null
     */
    public function find(int $id)
    {
        try {
            return $this->withCategoryaAndUser()
                ->where("{$this->table}.id", compact('id'))
                ->all()->get(0);
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve a podcast with specific conditions
     * @param string $field
     * @param $value
     * @return Object|array|null
     */
    public function findWith(string $field, $value)
    {
        try {
            return $this->withCategoryaAndUser()
                ->where("{$this->table}.{$field} = ?", [$field => $value])
                ->all()->get();
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Base Query for singlePagination
     * @return Select
     */
    private function singlePagination()
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select(["{$this->table}.name", "{$this->table}.slug", "{$this->table}.id"])
                ->limit(1);
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Retrieve the next record
     * @param $id
     * @return Object|array|null
     */
    public function next($id)
    {
        return $this->singlePagination()
            ->where("{$this->table}.id > ?", compact('id'))
            ->where("{$this->table}.online = 1")
            ->orderBy("{$this->table}.id ASC")
            ->all()->get(0);
    }

    /**
     * Retrieve the previous record
     * @param $id
     * @return Object|array|null
     */
    public function previous($id)
    {
        return $this->singlePagination()
            ->where("{$this->table}.id < ?", compact('id'))
            ->where("{$this->table}.online = 1")
            ->orderBy("{$this->table}.id DESC")
            ->all()->get(0);
    }
}
