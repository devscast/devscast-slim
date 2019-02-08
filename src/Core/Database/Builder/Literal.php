<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Database\Builder;

/**
 * SQL literal value
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
