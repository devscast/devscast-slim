<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\User;

use App\Tables;
use Exception;
use Framework\Database\AbstractRepository;
use Framework\Logger;

/**
 * Class UsersRepository
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Repositories
 */
class UsersRepository extends AbstractRepository
{

    /**
     * The table name in the database
     *
     * @var string
     */
    protected $table = Tables::USERS;

    /**
     * Entity class
     *
     * @var string
     */
    protected $entity = UsersEntity::class;

    /**
     * Retrieve a record with a specific condition
     *
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        try {
            return $this->makeQuery()
                ->into($this->entity)
                ->from($this->table)
                ->select("{$this->table}.*")
                ->where("{$this->table}.{$field} = ?", [$field => $value])
                ->all()
                ->get(0);
        } catch (Exception $e) {
            Logger::warning($e->getMessage(), [$e->getTraceAsString()]);
            return null;
        }
    }
}
