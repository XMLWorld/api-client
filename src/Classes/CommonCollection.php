<?php


namespace XMLWorld\ApiClient\Classes;


use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use XMLWorld\ApiClient\Interfaces\Serializable;

/**
 * @template T
 * @implements IteratorAggregate<T>
 */
class CommonCollection implements IteratorAggregate, Countable, Serializable, ArrayAccess
{
	/** @var array<T>  */
	protected array $data;

	/** @return ArrayIterator<int, T> */
	public function getIterator() : ArrayIterator
	{
		return new ArrayIterator($this->data);
	}

	public function count() : int
	{
		return count($this->data);
	}

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }
}