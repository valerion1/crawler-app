<?php declare( strict_types = 1 );

namespace App\Helpers;

use ArrayAccess;
use Countable;

/**
 * Class Collection
 * @package ImageParser
 */
class Collection implements Countable, ArrayAccess
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct (array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param mixed $item
     * @return Collection
     */
    public function push ($item) : self
    {
        $this->offsetSet(null, $item);

        return $this;
    }

    /**
     * @param array $items
     * @return Collection
     */
    public function append (array $items) : self
    {
        $this->items = array_merge($this->items, $items);

        return $this;
    }

    /**
     * @param callable $callback
     * @return Collection
     */
    public function map (callable $callback) : self
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static($items);
    }

    /**
     * @param callable $callback
     * @return Collection
     */
    public function each (callable $callback) : self
    {
        array_walk($this->items, $callback);

        return $this;
    }

    /**
     * @param string $delimiter
     * @return string
     */
    public function implode (string $delimiter = '') : string
    {
        return implode($delimiter, $this->items);
    }

    /**
     * @param callable $callback
     * @return self
     */
    public function sortBy (callable $callback) : self
    {
        usort($this->items, $callback);

        return $this;
    }

    /**
     * @return self
     */
    public function unique () : self
    {
        $this->items = array_unique($this->items);

        return $this;
    }

    /**
     * @param $searchItem
     * @return bool
     */
    public function contains ($searchItem) : bool
    {
        $filteredItems = array_filter(
            $this->items,
            function($item) use(&$searchItem) {
                return (string)$item === (string)$searchItem;
            }
        );

        return ! empty($filteredItems);
    }

    /**
     * @return mixed
     */
    public function first ()
    {
        foreach ($this->items as $item) {
            return $item;
        }

        return null;
    }

    /**
     * @return int
     */
    public function count () : int
    {
        return \count($this->items);
    }

    /**
     * @return bool
     */
    public function isNotEmpty () : bool
    {
        return ! $this->isEmpty();
    }

    /**
     * @return bool
     */
    public function isEmpty () : bool
    {
        return $this->count() === 0;
    }

    /**
     * @return mixed
     */
    public function shift ()
    {
        return array_shift($this->items);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists ($offset) : bool
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet ($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset ($offset) : void
    {
        unset($this->items[$offset]);
    }
}