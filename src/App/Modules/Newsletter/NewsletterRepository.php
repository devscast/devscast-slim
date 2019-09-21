<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace App\Repositories;

use App\Entities\NewsletterEntity;
use App\Modules;
use Framework\Repositories\Repository;

/**
 * Class NewsletterRepository
 * Abstraction of the newsletter table
 * @package App\Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class NewsletterRepository extends Repository
{

    /**
     * The table name in the database
     * @var string
     */
    protected $table = Modules::NEWSLETTER;


    /**
     * Entity class
     * @var NewsletterEntity
     */
    protected $entity = NewsletterEntity::class;
}
