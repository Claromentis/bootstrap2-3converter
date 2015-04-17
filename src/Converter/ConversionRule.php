<?php
namespace Converter;

abstract class ConversionRule
{
	public $is_modified = false;
	public $is_notable = false;

	/**
	 * @param string $tag
	 * @param array $attributes
	 *
	 * @return array
	 */
	abstract public function run($tag, $attributes);
}