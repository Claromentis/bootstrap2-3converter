<?php

namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

/**
 * Convert navigation lists
 *
 * @author Alexander Polyanskikh
 */
class NavListConversion extends ConversionRule
{
	public function run(Tag $tag)
	{
		if ($tag->HasClass('nav') && $tag->HasClass('nav-list'))
			$tag->ChangeClasses(['nav', 'nav-list'], ['nav', 'nav-pills', 'nav-stacked']);
	}
}