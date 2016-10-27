<?php
/*
 * Iterative binary search algorithm
 */

function binary_search(\Ds\Vector &$vector, $value) : bool
{
   $right = $vector->count() - 1;

   $left = 0;

   while($right >= $left) {

      $mid = floor(($right + $left) / 2);

      if ($vector[$mid] < $value) $left = $mid + 1;

      elseif ($vector[$mid] > $value) $right = $mid - 1;

      else return true;
   }

   return false;
}
