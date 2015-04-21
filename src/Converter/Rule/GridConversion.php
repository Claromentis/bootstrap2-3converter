<?php
namespace Converter\Rule;

use Converter\ConversionRule;
use Converter\Tag;

class GridConversion extends ConversionRule
{
	private $_element;

	protected $_rules;


	public function __construct()
	{
		$this->_rules = array(
			"row-fluid" => "row",
			"container-fluid" => "",
			"span(\\d+)" => array("col-md-$1", 'specialReplace'),
			"offset(\\d+)" => array("col-md-offset-$1", 'specialReplace')
		);
	}

	/**
	 * Revamped Grid System
	 *
	 * * Looks for 'spanX' non-form containers and replaces with 'col-md-X'
	 * * Looks for 'offsetX' non-form containers and replaces with 'col-lg-offset-X'
	 * * Change 'row-fluid' to 'row'
	 * * Remove 'container-fluid'
	 *
	 * @param Tag $tag
	 */
	public function run(Tag $tag)
	{
		$this->_element = $tag->tag;

		// take the class attribute for element $_tag
		if (isset($tag->attributes['class']))
		{
			$before = $tag->attributes['class'];
			$classes_str = $tag->attributes['class'];

			// each rule
			foreach ($this->_rules as $old => $new)
			{
				// plain old preg_replace, or custom replace?
				if (is_array($new))
					$classes_str = call_user_func_array(array($this, $new[1]), array($old, $new, $classes_str));
				else
					$classes_str = preg_replace("/$old/", $new, $classes_str);
			}

			// set modified
			if ($before != $classes_str)
			{
				$tag->SetClassesStr($classes_str);
				$tag->is_modified = true;
			}
		}
	}

	/**
	 * Only runs class replacement if conditions are met
	 *
	 * @param string $old regex
	 * @param array $new (css class, callable)
	 * @param string $classes_str
	 *
	 * @return mixed replaced class name
	 */
	private function specialReplace($old, $new, $classes_str)
	{
		if (strpos('li|section|div|aside|article', $this->_element) !== false)
		{
			return preg_replace("/$old/", $new[0], $classes_str);
		}

		// else return the original class
		return $classes_str;
	}
}