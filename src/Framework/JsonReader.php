<?php
/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework;

use stdClass;

/**
 * Class JsonReader
 *
 * @author bernard-ng <ngandubernard@gmail.com>
 * @package Framework
 */
class JsonReader
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
     * using a json file as database
     * @param string $json
     */
    public function __construct(string $json)
    {
        $this->file = $json;
    }
    /**
     * Parse the json file
     * @param bool $asArray
     * @return mixed|stdClass[]|string
     */
    public function getData(bool $asArray = false)
    {
        if (is_null($this->data)) {
            $this->data = (string) file_get_contents($this->file);
            $this->data = json_decode($this->data, $asArray);
        }
        return $this->data;
    }
}
