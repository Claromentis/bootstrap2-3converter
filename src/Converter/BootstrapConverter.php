<?php
namespace Converter;

/**
 * Main converter class
 *
 * @package Converter
 */
class BootstrapConverter
{
	/**
	 * @var ConversionRule[]
	 */
	protected $rules;
	protected $log_function;

	private $cur_file_info = [];

	public function __construct()
	{
		$this->rules = array(
			new Rule\GridConversion(),
			new Rule\FormConversion(),
			new Rule\BtnConversion(),
			new Rule\AlertConversion(),
			new Rule\ListsConversion(),
			new Rule\NavListConversion(),
			new Rule\ThumbnailsConversion(),
			new Rule\IconsConversion(),
		);
	}

	/**
	 * Begin conversion process
	 *
	 * @param $directory
	 */
	public function Run($directory)
	{
		// create a directory iterator
		$iter = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::SELF_FIRST
		);

		/**
		 * @var  string $path
		 * @var  \SplFileInfo $dir
		 */
		foreach ($iter as $path => $dir)
		{
			if ($dir->getExtension() == 'html')
			{
				$this->cur_file_info = array(
					'path' => $path,
					'is_affected' => false,
					'is_notable' => false,
				);
				$this->ConvertFile($path);

				$func = $this->log_function;
				$func($path, $this->cur_file_info);
			}
		}

		return;
	}

	/**
	 * @param ConversionRule $rule
	 */
	public function AddConversionRule(ConversionRule $rule)
	{
		$this->rules[] = $rule;
	}

	/**
	 * @param ConversionRule[] $rules
	 */
	public function SetConversionRules($rules)
	{
		$this->rules = $rules;
	}

	/**
	 * Regex match the contents of each html file for its markup.
	 *
	 * @param string $path
	 */
	private function ConvertFile($path)
	{
		$string = file_get_contents($path);

		// regex finds html tags, but not closing html tags, $result = the final modified file (as string)
		$result = preg_replace_callback('/<[^\/](?:"[^"]*"|\'[^\']*\'|[^\'">])*>/', array($this, 'matchAttributes'), $string);

		file_put_contents($path, $result);
	}

	public function SetLogFunction(Callable $func)
	{
		$this->log_function = $func;
	}

	/**
	 * Callback for HTML tag regex.
	 * Performs regex on the html tag match to determine attribute key value pairs.
	 *
	 * @param $full_tag
	 *
	 * @return string
	 */
	private function matchAttributes($full_tag)
	{
		$full_tag = $full_tag[0];

		//$replacement = preg_replace_callback('/(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/',

		if (preg_match('/^<(\w+)\s/', $full_tag, $matches))
			$tag = $matches[1];
		else
			return $full_tag;

		$attrs = $this->GetAllTagAttributes($full_tag);

		$tag = new Tag($tag, $attrs);

		$replacement = preg_replace_callback('/class="([^"]{2,70})"/',
			function ($match) use ($tag)
			{
				$tag->SetClassesStr($match[1]);
				return $this->ConvertTag($tag);
			}, $full_tag);

		return $replacement;
	}

	/**
	 * Executed on match of attributes within an HTML tag.
	 * Performs all of the conversion commands
	 *
	 * @param Tag $tag_obj
	 *
	 * @return string
	 */
	private function ConvertTag($tag_obj)
	{
		foreach ($this->rules as $rule)
		{
			$rule->run($tag_obj);
		}

		// generate replacement string
		$replacement = '';
		foreach ($tag_obj->attributes as $k => $v)
			$replacement = strlen($v) ? $k . '="' . $v . '"' : '';

		// add file to list of affected files
		$this->cur_file_info['is_affected'] = $tag_obj->is_modified || $this->cur_file_info['is_affected'];
		$this->cur_file_info['is_notable'] = $tag_obj->is_notable || $this->cur_file_info['is_notable'];

		return $replacement;
	}

	private function GetAllTagAttributes($full_tag)
	{
		$attrs = [];
		if (preg_match_all('/(\S+)="(.*?)"/', $full_tag, $matches, PREG_SET_ORDER))
		{
			foreach ($matches as $m)
			{
				$attrs[$m[1]] = $m[2];
			}
		}
		return $attrs;
	}
}