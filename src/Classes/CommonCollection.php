<?php


namespace XmlWorld\ApiClient\Classes;


use ArrayIterator;
use Countable;
use IteratorAggregate;
use XmlWorld\ApiClient\Interfaces\Serializable;

/**
 * @template T
 * @implements IteratorAggregate<T>
 */
class CommonCollection implements IteratorAggregate, Countable, Serializable
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
}