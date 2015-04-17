<?php
namespace Converter;

/**
 * Adds btn-default if only btn class exists
 *
 * @package Converter
 */
class BtnConversion extends ConversionRule
{
	/**
	 * @param Tag $tag
	 */
	public function run(Tag $tag)
	{
		if ($tag->HasClass('btn') && !$tag->HasClass('btn-(.*)'))
		{
			$tag->ChangeClasses([], ['btn-default']);
			$tag->is_modified = true;
		}
	}
}