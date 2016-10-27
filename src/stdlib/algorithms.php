<?php
/*
 * Iterative binary $search algorithm
 */

function binary_search(\Ds\Vector &$vector, $search) : bool
{
/*
   $right = $vector->count() - 1;

   $left = 0;

   while($right >= $left) {

      $mid = (int) floor(($right + $left) / 2);

      if ($vector[$mid] < $value) $left = $mid + 1;

      elseif ($vector[$mid] > $value) $right = $mid - 1;

      else return true;
   }

   return false;
*/
   $first = 0;
   $last = $vector->count() - 1;
   
   $middle = (int) floor(($first+$last)/2);
 
   while ($first <= $last) {

      if ($vector[$middle] < $search)
         $first = $middle + 1;    

      else if ($vector[$middle] == $search) {
         //printf("%d found at location %d.\n", $search, $middle+1);
         return true;
      }
      else
         $last = $middle - 1;
 
      $middle = (int) (floor($first + $last)/2);
   }
   return false;
}
