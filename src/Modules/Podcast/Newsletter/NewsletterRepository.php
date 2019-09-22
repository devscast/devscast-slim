<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Podcast\Newsletter;

use App\Tables;
use Framework\Database\AbstractRepository;

/**
 * Class NewsletterRepository
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package App\Modules\Newsletter
 */
class NewsletterRepository extends AbstractRepository
{

    /**
     * The table name in the database
     *
     * @var string
     */
    protected $table = Tables::NEWSLETTER;


    /**
     * Entity class
     *
     * @var NewsletterEntity
     */
    protected $entity = NewsletterEntity::class;
}
