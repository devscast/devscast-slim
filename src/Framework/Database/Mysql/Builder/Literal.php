<?php

/**
 * This file is part of DevsCast.
 * (c) Bernard Ng <ngandubernard@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Framework\Database\Mysql\Builder;

/**
 * Class Literal
 * SQl Literal Value
 * @package Framework\Database\Builder
 * @link      https://github.com/envms/fluentpdo
 * @author    envms, start@env.ms
 * @copyright 2012-2018 env.ms - Chris Bornhoft, Aldo Matelli, Stefan Yohansson, Kevin Sanabria, Marek Lichtner
 * @license   https://www.gnu.org/licenses/gpl-3.0.en.html GNU General Public License, version 3.0
 */
class Literal
{

    /** @var string */
    protected $value = '';

    /**
     * Create literal value
     *
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get literal value
     *
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
