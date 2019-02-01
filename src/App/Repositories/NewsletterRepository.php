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

use App\Entities\NewsletterEntity;
use Core\Repository;

/**
 * Class NewsletterRepository
 * @package App\Repositories
 */
class NewsletterRepository extends Repository
{

    /**
     * the name of the table in the database
     * @var string
     */
    protected $table = 'newsletter';


    /**
     * the class that represent one newsLetter instance
     * @var NewsletterEntity
     */
    protected $entity = NewsletterEntity::class;
}
