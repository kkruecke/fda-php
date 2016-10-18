<?php
/*
 * Iterative binary search algorithm
 */

function binary_search(array &$array, $value) : bool
{
   $right = sizeof($array) - 1;

   $left = 0;

   while($right >= $left) {

      $mid = floor(($right + $left) / 2);

      if ($array[$mid] < $value) $left = $mid + 1;

      elseif ($array[$mid] > $value) $right = $mid - 1;

      else return true;
   }

   return false;
}
