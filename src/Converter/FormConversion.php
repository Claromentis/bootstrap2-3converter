<?php
namespace Converter;

class FormConversion extends ConversionRule
{
	protected $_rules;

	public function __construct()
	{
		$this->_rules = array(
			"control-label" => ["control-label", "col-sm-2"],
			"controls" => "col-sm-10",
			"control-group" => "form-group",
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
			{
				$tag->ChangeClasses([$orig], is_array($replacement) ? $replacement : [$replacement]);
				$tag->is_modified = true;
			}
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