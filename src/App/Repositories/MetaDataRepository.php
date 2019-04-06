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


/**
 * Class MetaDataRepository
 * @package App\Repositories
 */
class MetaDataRepository extends JsonFileRepository
{
    /**
     * MetaDataRepository constructor.
     * @param string $file
     */
    public function __construct(string $file = ROOT . "/data/meta.json")
    {
        $this->file = $file;
    }
}