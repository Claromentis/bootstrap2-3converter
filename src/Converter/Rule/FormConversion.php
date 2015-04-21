<?php
namespace Converter\Rule;

use Converter\ConversionRule;
use Converter\Tag;

class FormConversion extends ConversionRule
{
	protected $_rules;

	public function __construct()
	{
		$this->_rules = array(
			"control-label" => ["control-label", "col-md-3 col-sm-2"],
			"controls" => "col-md-9 col-sm-10",
			"control-group" => "form-group",
			"form-actions" => "col-md-offset-3 col-md-9 col-sm-offset-2 col-sm-10",
		);
	}

	/**
	 * @param Tag $tag
	 */
	public function run(Tag $tag)
	{
		foreach ($this->_rules as $orig=>$replacement)
		{
			$classes = $tag->GetClasses();
			if (in_array($orig, $classes))
				$tag->ChangeClasses([$orig], is_array($replacement) ? $replacement : [$replacement]);
		}

		if (in_array($tag->tag, ['input', 'select', 'textarea']))
		{
			if ($tag->tag == 'input' && isset($tag->extra_attributes['type']) && !in_array($tag->extra_attributes['type'], ['text', 'password']))
				;
			else
			{
				if (!$tag->HasClass('form-control') && !$tag->HasClass('btn'))
					$tag->ChangeClasses([], ['form-control']);
			}
		}

	}
}