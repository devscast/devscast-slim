<?php
/**
 * This file is part of the devcast.
 *
 * (c) Bernard Ng <ngandubernard@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Core;

use App\Repositories\JsonFileRepository;

/**
 * Class MetaManager
 * @package Core
 */
class MetaManager implements \ArrayAccess
{

    /**
     * @var array
     */
    public $metaStore;

    /**
     * @var \stdClass
     */
    private $meta;

    /**
     * @param string $name
     * @param $arguments
     * @return mixed
     */
    public function __call(string $name, $arguments)
    {
        $method = strtolower(substr($name, 0, 3));
        $field = strtolower(substr($name, 3));

        if ($method === "set") {
            $this->offsetSet($field, $arguments[0]);
        } elseif ($method === "get") {
            return $this->offsetGet($field);
        }
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \OutOfBoundsException
     */
    public function __get(string $name)
    {
        if ($this->offsetExists($name)) {
            return $this->offsetGet($name);
        }
        throw new \OutOfBoundsException(sprintf("the key %s does not exists", $name));
    }

    /**
     * @param string $name
     * @param $value
     */
    public function __set(string $name, $value): void
    {
        $this->offsetSet($name, $value);
    }

    /**
     * MetaManager constructor.
     */
    public function __construct()
    {
        $this->meta = (new class() extends JsonFileRepository {
            public function __construct(string $file = ROOT . "/data/meta.json")
            {
                $this->file = $file;
            }
        })->getData();
    }

    /**
     * @param string $name
     * @param string $content
     */
    public function setMeta(string $name, string $content): void
    {
        if (property_exists($this, $name)) {
            $this->offsetSet($name, $content);
        } else {
            $this->metaStore[$name] = $content;
        }
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
    public function offsetExists($offset): bool
    {
        return property_exists($this->meta, $offset);
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
        if ($this->offsetExists($offset)) {
            return $this->meta->$offset;
        }
        return null;
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
     */
    public function offsetSet($offset, $value): void
    {
        $this->meta->$offset = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     * @throws \RuntimeException
     */
    public function offsetUnset($offset): void
    {
        throw new \RuntimeException("Cannot unset a meta data");
    }
}
