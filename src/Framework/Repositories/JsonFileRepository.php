<?php

/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Framework\Repositories;

use stdClass;

/**
 * Class JsonFileRepository
 * @package App\Repositories
 * @author bernard-ng, https://bernard-ng.github.io
 */
class JsonFileRepository
{
    /**
     * database
     * @var string
     */
    protected $file;

    /**
     * quotes fetched form file
     * @var stdClass[]|array
     */
    protected $data;


    /**
     * Parse the json file
     * @return mixed|stdClass[]|string
     */
    public function getData()
    {
        if (is_null($this->data)) {
            $this->data = (string) file_get_contents($this->file);
            $this->data = json_decode($this->data);
        }
        return $this->data;
    }
}
