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

use stdClass;

/**
 * Class QuotesRepository
 * @package App\Repositories
 */
class QuotesRepository
{
    /**
     * database
     * @var string
     */
    private $file;

    /**
     * quotes fetched form file
     * @var stdClass[]|array
     */
    private $quotes;

    /**
     * using a file as database
     * QuotesRepository constructor.
     * @param string $file
     */
    public function __construct(string $file = ROOT . "/data/quotes.json")
    {
        if (file_exists($file)) {
            $this->file = $file;
        } else {
            throw new \InvalidArgumentException("the given filename is not a file");
        }
    }

    /**
     * Parse the json file
     * @return mixed|stdClass[]|string
     */
    public function getQuotes()
    {
        if (is_null($this->quotes)) {
            $this->quotes = (string) file_get_contents($this->file);
            $this->quotes = json_decode($this->quotes);
        }
        return $this->quotes;
    }

    /**
     * get one quote randomly
     * @return stdClass
     */
    public function random(): ?stdClass
    {
        $quotes = $this->getQuotes();
        $index = array_rand($quotes, 1);
        return $quotes[$index];
    }
}