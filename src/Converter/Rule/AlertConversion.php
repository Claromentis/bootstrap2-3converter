<?php
namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

/**
 * Converts alert messages:
 *  * adds aler-warning if no context class present at all
 *  * replaces alert-error by alert-danger
 *
 * @package Converter
 */
class AlertConversion extends ConversionRule
{
	/**
	 * @param Tag $tag
	 */
	public function run(Tag $tag)
	{
		if ($tag->HasClass('alert-error'))
			$tag->ChangeClasses(['alert-error'], ['alert-danger']);

		if ($tag->HasClass('alert') && !$tag->HasClass('alert-(.*)', true))
			$tag->ChangeClasses([], ['alert-warning']);
	}
}