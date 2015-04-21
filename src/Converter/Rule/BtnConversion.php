<?php
namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

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
		if ($tag->HasClass('btn'))
		{
			if (!$tag->HasClass('btn-(default|primary|success|info|warning|danger|link)', true))
				$tag->ChangeClasses([], ['btn-default']);

			if ($tag->HasClass('btn-small'))
				$tag->ChangeClasses(['btn-small'], ['btn-sm']);

			if ($tag->HasClass('btn-large'))
				$tag->ChangeClasses(['btn-large'], ['btn-lg']);
		}
	}
}