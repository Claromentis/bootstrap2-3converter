<?php

namespace Converter;

/**
 * Description of Tag.php
 *
 * @author Alexander Polyanskikh
 */
class Tag
{
	public $tag;
	public $attributes;
	public $extra_attributes;
	public $is_modified = false;
	public $is_notable = false;

	protected $classes;

	public function __construct($tag, $extra_attributes)
	{
		$this->tag = $tag;
		$this->extra_attributes = $extra_attributes;
		if (!isset($this->extra_attributes['class']))
		{
			$this->classes = [];
		} else
		{
			$this->attributes['class'] = $this->extra_attributes['class'];
		}
	}

	public function GetClasses()
	{
		if (is_null($this->classes))
		{
			$this->classes = preg_split("/\\s+/", $this->attributes['class']);
		}
		return $this->classes;
	}

	public function SetClasses($classes)
	{
		$this->classes = $classes;
		if (count($classes))
			$this->attributes['class'] = join(' ', $classes);
		else
			unset($this->attributes['class']);
	}

	public function SetClassesStr($classes_str)
	{
		if (!is_null($classes_str) && $classes_str != '')
		{
			$this->attributes['class'] = $classes_str;
			$this->classes = null;
		} else
		{
			unset($this->attributes['class']);
			$this->classes = [];
		}
	}

	public function ChangeClasses($remove, $add)
	{
		$classes = $this->GetClasses();
		$classes = array_diff($classes, $remove);
		$classes = array_merge($classes, $add);
		$this->SetClasses($classes);
	}

	public function HasClass($class_name, $is_regex = false)
	{
		$classes = $this->GetClasses();

		if (!$is_regex)
			return in_array($class_name, $classes);
		else
		{
			foreach ($classes as $c_name)
			{
				if (preg_match('/^'.$class_name.'$/', $c_name))
					return true;
			}
		}
		return false;
	}
}