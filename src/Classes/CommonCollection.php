<?php


namespace XmlWorld\ApiPackagePhp\Classes;


use ArrayIterator;
use Countable;
use IteratorAggregate;
use XmlWorld\ApiPackagePhp\Interfaces\Serializable;

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