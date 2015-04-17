<?php
namespace Converter;

abstract class ConversionRule
{
	/**
	 * @param Tag $tag
	 *
	 */
	abstract public function run(Tag $tag);
}