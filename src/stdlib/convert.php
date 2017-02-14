#!/usr/bin/env php
<?php
/*
 $argv[1] is an input .html or .htm file that will be converted using pandoc to Markdown and given an extension of .md instead of .html.
 */

$input = '"' . $argv[1] .'"';

$pos = strrpos($argv[1], ".");

$output_file = substr($argv[1], 0, $pos); 
$output_file .= ".md";
$output_file = '"' . $output_file . '"';

$cmd = "pandoc -f html -t markdown " . $input . " -o " . $output_file;

echo $cmd . "\n";
exec($cmd);
