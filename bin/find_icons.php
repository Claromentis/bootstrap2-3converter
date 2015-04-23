<?php
require_once __DIR__.'/../vendor/autoload.php';

if ($_SERVER['argc'] < 2)
{
	echo "Usage: ".$_SERVER['argv'][0]." {path}\n\n";
	exit;
}

$path = $_SERVER['argv'][1];

if (!is_dir($path))
{
	echo "$path is not a directory or not readable\n\n";
	exit;
}


$converter = new \Converter\BootstrapConverter();
$result = array(
	'affected' => [],
	'notable' => [],
	'count' => 0,
);
$converter->SetLogFunction(function ($file_path, $info) use (&$result) {
	$result['count']++;
	if ($info['is_affected'])
		$result['affected'][] = $file_path;
	if ($info['is_notable'])
		$result['notable'][] = $file_path;

	//echo $file_path." - ".($info['is_affected'] ? 'UPDATED' : 'not changed')."\n";
	echo ($info['is_affected'] ? '.' : 'x');
});

$icons = new \Converter\Rule\ClaIconsCollector();
$converter->SetConversionRules([$icons]);

$converter->Run($path);
echo "\n";

$icons_list = $icons->icons;
asort($icons_list);
var_export($icons_list);
echo "\nTotal icons: ".count($icons_list)."\n";