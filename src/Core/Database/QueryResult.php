<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Database;

/**
 * Class QueryResult
 * Abstraction for Raw Database query results
 * @package Core\Database
 * @author bernard-ng, https://bernard-ng.github.io
 */
class QueryResult implements \ArrayAccess, \Iterator
{
    /**
     * Raw results
     * @var array
     */
    private $records;

    /**
     * Index for iterating
     * @var int
     */
    private $index = 0;

    /**
     * Entity
     * @var null|string
     */
    private $entity;

    /**
     * Save the hydrated records to avoid multiple hydrations
     * @var array
     */
    private $hydratedRecords = [];

    /**
     * QueryResult constructor.
     * @param array $records
     * @param string|null $entity
     */
    public function __construct(array $records, ?string $entity)
    {
        $this->records = $records;
        $this->entity = $entity;
    }


    /**
     * Retrieve a result thanks to its index, Hydrate all result
     * if id is null
     * @param int $index
     * @return mixed
     */
    public function get(?int $index = null)
    {
        if (!is_null($this->entity)) {
            if (is_null($index)) {
                foreach ($this->records as $i => $record) {
                    if (!isset($this->hydratedRecords[$i])) {
                        $this->hydratedRecords[$i] = Hydrator::hydrate($record, $this->entity);
                    }
                }
                return $this->hydratedRecords;
            } elseif (!isset($this->hydratedRecords[$index])) {
                $this->hydratedRecords[$index] = Hydrator::hydrate($this->records[$index], $this->entity);
                return $this->hydratedRecords[$index];
            }
        }
        return $this->entity;
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->records[$this->index];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next(): void
    {
        $this->index++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return isset($this->records[$this->index]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->records[$offset]);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws \LogicException
     */
    public function offsetSet($offset, $value)
    {
        throw new \LogicException("Can't alter records");
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws \LogicException
     */
    public function offsetUnset($offset)
    {
        throw new \LogicException("Can't alter records");
    }
}
