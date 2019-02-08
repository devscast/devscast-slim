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
use Core\Repositories\Repository;

/**
 * Class PodcastsRepository
 * @package App\Repositories
 */
class PodcastsRepository extends Repository
{

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table = 'podcasts';

    /**
     * the class that represents one podcast
     * @var PodcastsEntity
     */
    protected $entity = PodcastsEntity::class;


    /**
     * get with category and user
     * @return Select
     */
    private function withCategoryaAndUser(): Select
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->select("categories.name AS category")
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
     * Get the latest podcasts
     * @param int $limit
     * @return Object|array|mixed
     */
    public function latest(int $limit)
    {
        return $this->withCategoryaAndUser()->limit($limit)->all()->get();
    }

    /**
     * GET the last podcast
     * @return Object|array|mixed
     */
    public function last()
    {
        return $this->withCategoryaAndUser()->limit(1)->all()->get(0);
    }

    /**
     * get one podcast thanks to an 'id'
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
     * @param $id
     * @return Object|array|mixed
     */
    public function next($id)
    {
        return $this->withCategoryaAndUser()
            ->where("{$this->table}.id > ?", compact('id'))
            ->all()->get(0);
    }

    /**
     * @param $id
     * @return Object|array|mixed
     */
    public function previous($id)
    {
        return $this->withCategoryaAndUser()
            ->where("{$this->table} < ?", compact('id'))
            ->limit(1)
            ->all()->get(0);
    }
}
