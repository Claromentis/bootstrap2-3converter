<?php

namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

/**
 *
 * @author Alexander Polyanskikh
 */
class ThumbnailsConversion extends ConversionRule
{
	/**
	 * @param Tag $tag
	 *
	 */
	public function run(Tag $tag)
	{
		if ($tag->tag == 'ul' && $tag->HasClass('thumbnails') && !$tag->HasClass('list-unstyled'))
			$tag->ChangeClasses([], ['list-unstyled']);
	}
}