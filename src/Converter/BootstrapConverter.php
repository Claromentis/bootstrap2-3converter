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

	protected $base_dir;
	protected $current_dir;

	public $affected_files = array();
	public $notable_files = array();


	public function __construct($directory)
	{
		$this->base_dir = $directory;
	}

	/**
	 * Begin conversion process
	 */
	public function begin()
	{
		$this->rules = array(
			new GridConversion(),
			new FormConversion(),
		);


		// create a directory iterator
		$iter = new \RecursiveIteratorIterator(
			new \RecursiveDirectoryIterator($this->base_dir, \RecursiveDirectoryIterator::SKIP_DOTS),
			\RecursiveIteratorIterator::SELF_FIRST
		);

		/**
		 * @var  string $path
		 * @var  \SplFileInfo $dir
		 */
		$count = 0;
		$files = array();
		foreach ($iter as $path => $dir)
		{
			if ($dir->getExtension() == 'html')
			{
				$files[] = $path;
				$this->current_dir = $path;
				$this->replace($path);
				$count++;
			}

			// break after first file has been read, debug only.
			//if( $count == 1 ) break;
		}

		return array(
			'files' => $files,
			'count' => $count,
			'affected' => $this->affected_files,
			'affected_count' => count($this->affected_files),
			'notable' => $this->notable_files,
			'notable_count' => count($this->notable_files)
		);
	}

	/**
	 * Regex match the contents of each html file for its markup.
	 *
	 * @param string $path
	 */
	private function replace($path)
	{
		$string = file_get_contents($path);

		// regex finds html tags, but not closing html tags, $result = the final modified file (as string)
		$result = preg_replace_callback('/<[^\/](?:"[^"]*"|\'[^\']*\'|[^\'">])*>/', array($this, 'matchAttributes'), $string);

		file_put_contents($path, $result);
	}

	/**
	 * Callback for HTML tag regex.
	 * Performs regex on the html tag match to determine attribute key value pairs.
	 *
	 * @param $tag
	 *
	 * @return string
	 */
	private function matchAttributes($tag)
	{
		$tag = $tag[0];

		//$replacement = preg_replace_callback('/(\S+)=["\']?((?:.(?!["\']?\s+(?:\S+)=|[>"\']))+.)["\']?/',
		$replacement = preg_replace_callback('/(\S+)="([^"]{2,70})"/',
			function ($match) use ($tag)
			{
				return $this->convert($match[1], $match[2], $tag);
			}, $tag);

		return $replacement;
	}

	/**
	 * Executed on match of attributes within an HTML tag.
	 * Performs all of the conversion commands
	 *
	 * @param string $attribute
	 * @param string $attr_value
	 * @param string $tag
	 *
	 * @return string
	 */
	private function convert($attribute, $attr_value, $tag)
	{
		$attributes = array($attribute => $attr_value);
		$modified = 0;
		$notable = 0;

		foreach ($this->rules as $rule)
		{
			$attributes = $rule->run($tag, $attributes);
			if ($rule->is_modified)
				$modified++;
			if ($rule->is_notable)
				$notable++;
		}

		// generate replacement string
		foreach ($attributes as $k => $v)
			$replacement = strlen($v) ? $k . '="' . $v . '"' : '';


		// add file to list of affected files
		if ($modified && !in_array($this->current_dir, $this->affected_files))
			$this->affected_files[] = $this->current_dir;

		if ($notable && !in_array($this->current_dir, $this->notable_files))
			$this->notable_files[] = $this->current_dir;

		return $replacement;
	}
}