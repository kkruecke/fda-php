<?php
use \Ds\Vector;

$vector = new Vector();

$vector->push('a');
$vector->push('b', 'c');

$vector[] = 'd';

print_r($vector);

?>

