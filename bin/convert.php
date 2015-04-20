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


$converter = new \Converter\BootstrapConverter($path);
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

	echo $file_path." - ".($info['is_affected'] ? 'UPDATED' : 'not changed')."\n";
});

$converter->begin();

//echo "Affected files: ".join("\n", $result['affected'])."\n\n";
//echo "Notable files: ".join("\n", $result['notable'])."\n\n";
echo "Total checked: ".$result['count']."\n";
echo "Total affected: ".count($result['affected'])."\n";
echo "Total notable: ".count($result['notable'])."\n";
