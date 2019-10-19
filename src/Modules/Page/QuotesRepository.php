<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Modules\Page;

use Framework\JsonReader;
use InvalidArgumentException;
use stdClass;

/**
 * Class QuotesRepository
 *
 * @author bernard-ng, https://bernard-ng.github.io
 * @package App\Repositories
 */
class QuotesRepository extends JsonReader
{
    /**
     * using a file as database
     * QuotesRepository constructor.
     *
     * @param string $file
     */
    public function __construct(string $file = ROOT . "/data/quotes.json")
    {
        if (file_exists($file)) {
            parent::__construct($file);
            $this->file = $file;
        } else {
            throw new InvalidArgumentException("the given filename is not a file");
        }
    }

    /**
     * get one quote randomly
     *
     * @return stdClass
     */
    public function random(): ?stdClass
    {
        $quotes = $this->getData();
        $index = array_rand($quotes, 1);
        return $quotes[$index];
    }
}
