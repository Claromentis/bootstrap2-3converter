<?php
namespace Converter;

class FormConversion extends ConversionRule
{
	private $_element;

	protected $_rules;


	public function __construct()
	{
		$this->_rules = array(
			"control-label" => "control-label col-sm-2",
			"controls" => "col-sm-10",
			"control-group" => "form-group",
		);
	}

	/**
	 * Revamped Grid System
	 *
	 */
	public function run($tag, $attributes)
	{
		// match opening tag and retrieve the element name
		preg_match('/^<(\w+)\s/', $tag, $matches);
		if ($matches && count($matches) == 2)
			$this->_element = $matches[1];


		// take the class attribute for element $_tag
		if (array_key_exists('class', $attributes))
		{
			$before = $attributes['class'];

			// each rule
			foreach ($this->_rules as $old => $new)
			{
				// plain old preg_replace, or custom replace?
				if (is_array($new))
					$attributes['class'] = call_user_func_array(array($this, $new[1]), array($old, $new, $attributes));
				else
					$attributes['class'] = preg_replace("/$old/", $new, $attributes['class']);
			}

			// set modified
			if ($before != $attributes['class'])
				$this->is_modified = true;
		}

		return $attributes;
	}
}