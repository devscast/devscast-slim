<?php
namespace App\Repositories;

use App\Entities\PodcastsEntity;


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
     * @inheritdoc
     * @return mixed
     */
    public function all()
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
ORDER BY {$this->getTable()}.id DESC
SQL;

        return $this->query($sql);
    }


    /**
     * Get the latest podcast
     * @param int $limit
     * @return mixed
     */
    public function latest(int $limit)
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
ORDER BY {$this->getTable()}.id DESC
LIMIT {$limit} OFFSET 0
SQL;
        return $this->query($sql);
    }


    /**
     * GET the last podcast
     * @return mixed
     */
    public function last()
    {
        $sql = <<< SQL
SELECT {$this->getTable()}.* , categories.name AS category, users.name AS username
FROM {$this->getTable()}
LEFT JOIN categories ON {$this->getTable()}.categories_id = categories.id
LEFT JOIN users ON {$this->getTable()}.users_id = users.id
ORDER BY {$this->getTable()}.id DESC
LIMIT 1
SQL;
        return $this->query($sql, [], true, false);
    }
}