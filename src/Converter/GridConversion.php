<?php
namespace Converter;

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
			"offset(\\d+)" => array("col-lg-offset-$1", 'specialReplace')
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
	 * @param string $tag
	 * @param array $attributes
	 *
	 * @return array
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

	/**
	 * Only runs class replacement if conditions are met
	 *
	 * @param string $old regex
	 * @param array $new (css class, callable)
	 * @param string $pair key value pair
	 *
	 * @return mixed replaced class name
	 */
	private function specialReplace($old, $new, $pair)
	{
		// only preg_replace if we are <section> <div> <aside> or <article>
		if (strpos('section|div|aside|article', $this->_element) !== false)
		{
			return preg_replace("/$old/", $new[0], $pair['class']);
		}

		// else return the original class
		return $pair['class'];
	}
}