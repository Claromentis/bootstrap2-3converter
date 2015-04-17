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
$result = $converter->begin();

echo "Affected files: ".join("\n", $result['affected'])."\n\n";
echo "Notable files: ".join("\n", $result['notable'])."\n\n";
echo "Total checked: ".$result['count']."\n";
echo "Total affected: ".$result['affected_count']."\n";
echo "Total notable: ".$result['notable_count']."\n";
