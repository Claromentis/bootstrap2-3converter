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
			'cla-icon' => '',
			'cla-icon-clipboard-text' => 'glyphicons-notes-2',
			'cla-icon-link-break' => 'glyphicons-cat',
			'cla-icon-feed-document' => 'glyphicons-cat',
			'cla-icon-application-cascade' => 'glyphicons-sort',
			'cla-icon-zone' => 'glyphicons-modal-window',
			'cla-icon-rss' => 'social social-rss',
			'cla-icon-picture' => 'glyphicons-picture',
			'cla-icon-pin' => 'glyphicons-pushpin',
			'cla-icon-page-white-get' => 'glyphicons-file-export',
			'cla-icon-brick' => 'glyphicons-more',
			'cla-icon-user-business-boss' => 'glyphicons-glyphicons-user-key',
			'cla-icon-weather-sun' => 'glyphicons-sun',
			'cla-icon-box' => 'glyphicons-package',
			'cla-icon-envelope' => 'glyphicons-envelope',
			'cla-icon-application-view-list' => 'glyphicons-list-alt',
			'cla-icon-thumbs-down' => 'glyphicons-thumbs-down',
			'cla-icon-selection' => 'glyphicons-vector-path-square',
			'cla-icon-parent' => 'glyphicons-chevron-up',
			'cla-icon-drive-network' => 'glyphicons-hdd',
			'cla-icon-tag-blue' => 'glyphicons-tag',
			'cla-icon-application-add' => 'glyphicons-plus',
			'cla-icon-application2' => 'glyphicons-circle-plus',
			'cla-icon-view-icon' => 'glyphicons-show-big-thumbnails',
			'cla-icon-view-list-details' => 'glyphicons-list',
			'cla-icon-user-business' => 'glyphicons-user-key',
			'cla-icon-application-go' => 'glyphicons-cat',
			'cla-icon-layout' => 'glyphicons-cat',
			'cla-icon-css' => 'glyphicons-cat',
			'cla-icon-note' => 'glyphicons-cat',
			'cla-icon-switch' => 'glyphicons-cat',
			'cla-icon-lock' => 'glyphicons-lock',
			'cla-icon-doc-convert' => 'glyphicons-duplicate',
			'cla-icon-page-white-world' => 'glyphicons-cat',
			'cla-icon-blank' => 'glyphicons-cat',
			'cla-icon-email-open' => 'glyphicons-cat',
			'cla-icon-arrow-undo' => 'glyphicons-undo',
			'cla-icon-chart-bar' => 'glyphicons-charts',
			'cla-icon-bullet-subtract' => 'glyphicons-cat',
			'cla-icon-application-lightning' => 'glyphicons-cat',
			'cla-icon-email-archive' => 'glyphicons-cat',
			'cla-icon-user' => 'glyphicons-user',
			'cla-icon-page-copy' => 'glyphicons-duplicate',
			'cla-icon-computer' => 'glyphicons-imac',
			'cla-icon-delete2' => 'glyphicons-remove-2',
			'cla-icon-application-view-columns' => 'glyphicons-list-alt',
			'cla-icon-arrow-left' => 'glyphicons-left-arrow',
			'cla-icon-application-error' => 'glyphicons-alert',
			'cla-icon-bell' => 'glyphicons-bell',
			'cla-icon-traffic' => 'glyphicons-cat',
			'cla-icon-hammer-screwdriver' => 'glyphicons-settings',
			'cla-icon-page-white-text' => 'glyphicons-cat',
			'cla-icon-vcard' => 'glyphicons-vcard',
			'cla-icon-telephone' => 'glyphicons-earphone',
			'cla-icon-application-key' => 'glyphicons-cat',
			'cla-icon-application-view-tile' => 'glyphicons-cat',
			'cla-icon-timeline-marker' => 'glyphicons-ruler',
			'cla-icon-bookmark' => 'glyphicons-bookmark',
			'cla-icon-email-send' => 'glyphicons-cat',
			'cla-icon-accordion-closed' => 'glyphicons-collapse',
			'cla-icon-thumbs-up' => 'glyphicons-thumbs-up',
			'cla-icon-select-user' => 'glyphicons-cat',
			'cla-icon-doc-tag' => 'glyphicons-cat',
			'cla-icon-select' => 'glyphicons-cat',
			'cla-icon-world' => 'glyphicons-globe-af',
			'cla-icon-table' => 'glyphicons-table',
			'cla-icon-arrow-out' => 'glyphicons-move',
			'cla-icon-dashboard' => 'glyphicons-dashboard',
			'cla-icon-doc-table' => 'glyphicons-cat',
			'cla-icon-application-put' => 'glyphicons-file-import',
			'cla-icon-lock2' => 'glyphicons-lock',
			'cla-icon-textfield-rename' => 'glyphicons-cat',
			'cla-icon-arrow-divide' => 'glyphicons-flowchart',
			'cla-icon-checkin' => 'glyphicons-file-import',
			'cla-icon-control-pause' => 'glyphicons-pause',
			'cla-icon-radio-button' => 'glyphicons-cat',
			'cla-icon-doc-pdf' => 'glyphicons-cat',
			'cla-icon-office' => 'glyphicons-building',
			'cla-icon-user-silhouette' => 'glyphicons-user',
			'cla-icon-cancel' => 'glyphicons-circle-remove',
			'cla-icon-doc-text-image' => 'glyphicons-cat',
			'cla-icon-text-list-bullets' => 'glyphicons-list',
			'cla-icon-control-stop' => 'glyphicons-stop',
			'cla-icon-email-receive' => 'glyphicons-cat',
			'cla-icon-script' => 'glyphicons-plus',
			'cla-icon-alarm' => 'glyphicons-alarm',
			'cla-icon-doc-google' => 'glyphicons-cat',
			'cla-icon-lightning' => 'glyphicons-filter',
			'cla-icon-textarea' => 'glyphicons-cat',
			'cla-icon-doc-excel-csv' => 'glyphicons-cat',
			'cla-icon-checkbox' => 'glyphicons-cat',
			'cla-icon-chart-organisation' => 'glyphicons-cat',
			'cla-icon-package' => 'glyphicons-cat',
			'cla-icon-email-edit' => 'glyphicons-cat',
			'cla-icon-folder-open' => 'glyphicons-cat',
			'cla-icon-room' => 'glyphicons-cat',
			'cla-icon-arrow-branch' => 'glyphicons-cat',
			'cla-icon-error' => 'glyphicons-cat',
			'cla-icon-exclamation-octagon-frame' => 'glyphicons-cat',
			'cla-icon-feed' => 'glyphicons-cat',
			'cla-icon-asterisk-orange' => 'glyphicons-cat',
			'cla-icon-newspaper' => 'glyphicons-newspaper',
			'cla-icon-lock-unlock' => 'glyphicons-unlock',
			'cla-icon-page-white-text-add' => 'glyphicons-cat',
			'cla-icon-comment' => 'glyphicons-comments',
			'cla-icon-books' => 'glyphicons-cat',
			'cla-icon-page-white-edit' => 'glyphicons-cat',
			'cla-icon-application-form' => 'glyphicons-cat',
			'cla-icon-calendar-empty' => 'glyphicons-calendar',
			'cla-icon-control-play' => 'glyphicons-play',
			'cla-icon-marker' => 'glyphicons-google-maps',
			'cla-icon-control-record' => 'glyphicons-record',
			'cla-icon-group' => 'glyphicons-group',
			'cla-icon-page' => 'glyphicons-file',
			'cla-icon-page-white-put' => 'glyphicons-file-export',
			'cla-icon-close' => 'glyphicons-remove-2',
			'cla-icon-clock' => 'glyphicons-clock',
			'cla-icon-doc-page-previous' => 'glyphicons-cat',
			'cla-icon-report' => 'glyphicons-charts',
			'cla-icon-house' => 'glyphicons-home',
			'cla-icon-view-list' => 'glyphicons-justify',
			'cla-icon-html' => 'glyphicons-cat',
			'cla-icon-textfield' => 'glyphicons-cat',
			'cla-icon-cog' => 'glyphicons-cogwheel',
			'cla-icon-folder-add' => 'glyphicons-folder-plus',
			'cla-icon-find' => 'glyphicons-search',
			'cla-icon-delete' => 'glyphicons-ban',
			'cla-icon-email' => 'glyphicons-envelope',
			'cla-icon-arrow-refresh' => 'glyphicons-refresh',
			'cla-icon-page-white-delete' => 'glyphicons-bin',
			'cla-icon-blog' => 'glyphicons-cat',
			'cla-icon-doc-page' => 'glyphicons-cat',
			'cla-icon-grid-dot' => 'glyphicons-menu-hamburger',
			'cla-icon-monitor' => 'glyphicons-imac',
			'cla-icon-exclamation' => 'glyphicons-circle-info',
			'cla-icon-arrow-up' => 'glyphicons-up-arrow',
			'cla-icon-calendar1' => 'glyphicons-calendar',
			'cla-icon-arrow-down' => 'glyphicons-down-arrow',
			'cla-icon-star-empty' => 'glyphicons-star-empty',
			'cla-icon-eye' => 'glyphicons-eye-open',
			'cla-icon-folder' => 'glyphicons-folder-closed',
			'cla-icon-color-swatch2' => 'glyphicons-bucket',
			'cla-icon-accept' => 'glyphicons-ok-2',
			'cla-icon-star2' => 'glyphicons-star',
			'cla-icon-disabled' => 'disabled',
			'cla-icon-key' => 'glyphicons-keys',
			'cla-icon-pencil' => 'glyphicons-pencil',
			'cla-icon-add' => 'glyphicons-plus',
			'cla-icon-bin-closed' => 'glyphicons-bin',
			'icon-record' => 'glyphicons-record',
			'icon-repeat' => 'glyphicons-repeat',
			'icon-parents' => 'glyphicons-parents',
			'icon-group' => 'glyphicons-group',
			'icon-asterisk' => 'glyphicons-asterisk',
			'icon-home' => 'glyphicons-home',
			'icon-stopwatch' => 'glyphicons-stopwatch',
			'icon-circle_remove' => 'glyphicons-circle-remove',
			'icon-unlock' => 'glyphicons-unlock',
			'icon-user_add' => 'glyphicons-user-add',
			'icon-chat' => 'glyphicons-chat',
			'icon-git_merge' => 'glyphicons-git-merge',
			'icon-new_window' => 'glyphicons-new-window',
			'icon-history' => 'glyphicons-history',
			'icon-stop' => 'glyphicons-stop',
			'icon-folder_closed' => 'glyphicons-folder-closed',
			'icon-more_windows' => 'glyphicons-more-windows',
			'icon-black' => 'glyphicons-black',
			'icon-white' => 'glyphicons-white',
			'icon-show_thumbnails_with_lines' => 'glyphicons-show_thumbnails_with_lines',
			'icon-notes_2' => 'glyphicons-notes-2',
			'icon-random' => 'glyphicons-random',
			'icon-show_lines' => 'glyphicons-show-lines',
			'icon-magic' => 'glyphicons-magic',
			'icon-keys' => 'glyphicons-keys',
			'icon-more_items' => 'glyphicons-more-items',
			'icon-comments' => 'glyphicons-comments',
			'icon-paperclip' => 'glyphicons-paperclip',
			'icon-sort' => 'glyphicons-sort',
			'icon-expand' => 'glyphicons-expand',
			'icon-filter' => 'glyphicons-filter',
			'icon-folder_lock' => 'glyphicons-folder-lock',
			'icon-circle_exclamation_mark' => 'glyphicons-circle-exclamation-mark',
			'icon-bullhorn' => 'glyphicons-bullhorn',
			'icon-show_thumbnails' => 'glyphicons-show-thumbnails',
			'icon-user' => 'glyphicons-user',
			'icon-stats' => 'glyphicons-stats',
			'icon-charts' => 'glyphicons-charts',
			'icon-justify' => 'glyphicons-justify',
			'icon-pin_flag' => 'glyphicons-pin-flag',
			'icon-more' => 'glyphicons-more',
			'icon-remove_2' => 'glyphicons-remove-2',
			'icon-git_branch' => 'glyphicons-git-branch',
			'icon-file_import' => 'glyphicons-file-import',
			'icon-upload' => 'glyphicons-upload',
			'icon-spin' => 'glyphicons-spin',
			'icon-ok_2' => 'glyphicons-ok-2',
			'icon-circle_plus' => 'glyphicons-circle-plus',
			'icon-circle_info' => 'glyphicons-circle-info',
			'icon-chevron-right' => 'glyphicons-chevron-right',
			'icon-clock' => 'glyphicons-clock',
			'icon-picture' => 'glyphicons-picture',
			'icon-file_export' => 'glyphicons-file-export',
			'icon-eye_open' => 'glyphicons-eye-open',
			'icon-unshare' => 'glyphicons-unshare',
			'icon-check' => 'glyphicons-check',
			'icon-file' => 'glyphicons-file',
			'icon-tag' => 'glyphicons-tag',
			'icon-lock' => 'glyphicons-lock',
			'icon-sorting' => 'glyphicons-sorting',
			'icon-list' => 'glyphicons-list',
			'icon-cogwheel' => 'glyphicons-cogwheel',
			'icon-download' => 'glyphicons-download',
			'icon-chevron-left' => 'glyphicons-chevron-left',
			'icon-circle_question_mark' => 'glyphicons-circle-question-mark',
			'icon-refresh' => 'glyphicons-refresh',
			'icon-plus' => 'glyphicons-plus',
			'icon-calendar' => 'glyphicons-calendar',
			'icon-pencil' => 'glyphicons-pencil',
			'icon-link' => 'glyphicons-link',
			'icon-search' => 'glyphicons-search',
			'icon-bin' => 'glyphicons-bin'
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
