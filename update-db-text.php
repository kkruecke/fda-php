<?php
function fixTitles($text) : string
{
   // Capitalize titles
   $patterns = array();
   $patterns[0] = '/dr/';
   $patterns[1] = '/mr/';
   $patterns[2] = '/ms/';
   $patterns[3] = '/mrs/';
   
   $replacements = array();
   $replacements[0] = 'Dr';
   $replacements[1] = 'Mr';
   $replacements[2] = 'Ms';
   $replacements[3] = 'Mrs';

   $text = preg_replace($patterns, $replacements, $text); 
  
   return $text; 
}

   new \PDO(...)

   // Read all Medwatch rows using database text reader iterator 
   $db_text_reader = ...
   $db_write_iterator = ...

   foreach ($db_text_reader $text) {

        $text = fixTitles($text); 

        // update the current text using the database write iterator.
        $db_write_iterator->write($text);
   }

   


