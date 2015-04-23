<?php

namespace Converter\Rule;
use Converter\ConversionRule;
use Converter\Tag;

/**
 * Converts cla-icon-* to glyphicons-*
 *
 * and converts icon-* to equivalent glyphicon, if specified
 *
 * @author Alexander Polyanskikh
 */
class IconsConversion extends ConversionRule
{
	private $replacement;

	public function __construct()
	{
		$this->replacement = [
			'cla-icon-bin-closed' => 'glyphicons-bin',
			'cla-icon-house' => 'glyphicons-home',
			'cla-icon-add' => 'glyphicons-plus',
			'cla-icon-find' => 'glyphicons-search',
			'cla-icon-folder-add' => 'glyphicons-folder-plus',
			'cla-icon-telephone' => 'glyphicons-phone-alt',
			'cla-icon-user-silhouette' => 'glyphicons-user',
			'cla-icon-cog' => 'glyphicons-cogwheel',
			'icon-only' => '',
		    'icon-bin' => 'glyphicons-bin',
		    'icon-pencil' => 'glyphicons-pencil',
//			'icon-record' => 1,
//			'icon-repeat' => 1,
//			'icon-parents' => 1,
//			'icon-group' => 1,
//			'icon-asterisk' => 1,
//			'icon-home' => 1,
//			'icon-stopwatch' => 1,
//			'icon-circle_remove' => 1,
//			'icon-unlock' => 1,
//			'icon-user_add' => 1,
//			'icon-chat' => 1,
//			'icon-git_merge' => 1,
//			'icon-xstar' => 1,
//			'icon-new_window' => 1,
//			'icon-history' => 1,
//			'icon-stop' => 1,
//			'icon-folder_closed' => 1,
//			'icon-more_windows' => 1,
//			'icon-black' => 1,
//			'icon-white' => 1,
//			'icon-show_thumbnails_with_lines' => 1,
//			'icon-notes_2' => 1,
//			'icon-random' => 1,
//			'icon-show_lines' => 1,
//			'icon-magic' => 1,
//			'icon-keys' => 1,
//			'icon-more_items' => 1,
//			'icon-comments' => 1,
//			'icon-paperclip' => 1,
//			'icon-sort' => 1,
//			'icon-expand' => 1,
//			'icon-filter' => 1,
//			'icon-folder_lock' => 1,
//			'icon-circle_exclamation_mark' => 2,
//			'icon-bullhorn' => 2,
			'icon-show_thumbnails' => 'glyphicons-show-thumbnails',
//			'icon-user' => 2,
//			'icon-stats' => 2,
//			'icon-charts' => 2,
//			'icon-justify' => 2,
//			'icon-pin_flag' => 2,
//			'icon-more' => 2,
//			'icon-remove_2' => 2,
//			'icon-git_branch' => 2,
//			'icon-file_import' => 3,
//			'icon-upload' => 3,
//			'icon-spin' => 3,
//			'icon-ok_2' => 3,
//			'icon-circle_plus' => 3,
//			'icon-circle_info' => 3,
			'icon-chevron-right' => 'glyphicons-chevron-right',
//			'icon-clock' => 3,
//			'icon-picture' => 3,
//			'icon-file_export' => 4,
//			'icon-eye_open' => 4,
//			'icon-unshare' => 4,
//			'icon-check' => 4,
//			'icon-file' => 4,
			'icon-tag' => 'glyphicons-tag',
			'icon-lock' => 'glyphicons-lock',
			'icon-sorting' => 'glyphicons-sorting',
			'icon-list' => 'glyphicons-list',
			'icon-cogwheel' => 'glyphicons-cogwheel',
//			'icon-download' => 5,
			'icon-chevron-left' => 'glyphicons-chevron-left',
//			'icon-circle_question_mark' => 7,
//			'icon-refresh' => 7,
			'icon-plus' => 'glyphicons-plus',
			'icon-calendar' => 'glyphicons-calendar',
//			'icon-bar' => 9,
			'icon-link' => 'glyphicons-link',
			'icon-search' => 'glyphicons-search',
		];
	}

	/**
	 * @param Tag $tag
	 *
	 */
	public function run(Tag $tag)
	{
		if ($tag->HasClass('cla-icon-.*', true))
		{
			$remove = ['cla-icon'];
			$add = [];

			$classes = $tag->GetClasses();
			foreach ($classes as $class)
			{
				if (strpos($class, 'cla-icon-') === 0)
				{
					$remove[] = $class;

					if (isset($this->replacement[$class]))
					{
						if (!empty($this->replacement[$class]))
							$add[] = $this->replacement[$class];
					}
					else
						$add[] = 'glyphicons-'.substr($class, strlen('cla-icon-'));
				}
			}

			if (!empty($add) && !$tag->HasClass('glyphicons'))
				$add[] = 'glyphicons';

			$tag->ChangeClasses($remove, $add);
		}


		if ($tag->HasClass('icon-.*', true))
		{
			$remove = [];
			$add = [];

			$classes = $tag->GetClasses();
			foreach ($classes as $class)
			{
				if (strpos($class, 'icon-') === 0)
				{
					$remove[] = $class;

					if (isset($this->replacement[$class]))
					{
						if (!empty($this->replacement[$class]))
							$add[] = $this->replacement[$class];
					}
					else
						$add[] = $class; //'glyphicons-'.substr($class, strlen('icon-'));
				}
			}

			if (!$tag->HasClass('glyphicons'))
				$add[] = 'glyphicons';

			$tag->ChangeClasses($remove, $add);
		}

	}
}
