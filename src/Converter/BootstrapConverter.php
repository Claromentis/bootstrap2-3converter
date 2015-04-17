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
			new BtnConversion(),
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
				return $this->convert($tag);
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
	private function convert($tag_obj)
	{
		$modified = 0;
		$notable = 0;

		foreach ($this->rules as $rule)
		{
			$rule->run($tag_obj);
		}
		if ($tag_obj->is_modified)
			$modified++;
		if ($tag_obj->is_notable)
			$notable++;

		// generate replacement string
		$replacement = '';
		foreach ($tag_obj->attributes as $k => $v)
			$replacement = strlen($v) ? $k . '="' . $v . '"' : '';

		// add file to list of affected files
		if ($modified && !in_array($this->current_dir, $this->affected_files))
			$this->affected_files[] = $this->current_dir;

		if ($notable && !in_array($this->current_dir, $this->notable_files))
			$this->notable_files[] = $this->current_dir;

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