<?php

namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

/**
 *
 * @author Alexander Polyanskikh
 */
class ListsConversion extends ConversionRule
{
	private $rules;

	public function __construct()
	{
		$this->rules = [
			'unstyled' => 'list-unstyled'
		];
	}

	/**
	 * @param Tag $tag
	 *
	 */
	public function run(Tag $tag)
	{
		foreach ($this->rules as $search=>$replace)
		{
			if ($tag->HasClass($search))
				$tag->ChangeClasses([$search], [$replace]);
		}
	}
}