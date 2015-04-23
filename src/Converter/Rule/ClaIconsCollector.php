<?php

namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

/**
 * Collects icons usage stats. Does not modify the templates
 *
 * @author Alexander Polyanskikh
 */
class ClaIconsCollector extends ConversionRule
{
	public $icons = [];

	/**
	 * @param Tag $tag
	 *
	 */
	public function run(Tag $tag)
	{
		if ($tag->HasClass('cla-icon.*', true) || $tag->HasClass('icon-.*', true))
		{
			$classes = $tag->GetClasses();
			foreach ($classes as $class)
			{
				if (strpos($class, 'cla-icon') === 0 || strpos($class, 'icon-') === 0)
					$this->icons[$class] = 1 + (isset($this->icons[$class]) ? $this->icons[$class] : 0);
			}
		}
	}
}