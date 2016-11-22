<?php

function ucfirstword_sentences(string $str) : string
{
   $line = preg_replace_callback(
            '/(?:\.|\?|!)(\s+)[a-z]/',
            function ($matches) {
                return strtoupper($matches[0]); 
            },
            $str
           ); 

   return $line;
}

function fixText(string $text) : string
{
   // lowercase all text
   $text = strtolower($text);

   // capitalize start of sentences
   $text = ucfirstword_sentences($text);    

   // Capitalize the first character of the text.       
   $text = ucfirst($text);

   //  Capitalize the pronoun ' i '
   $text = preg_replace('/\b(i)\b/', 'I', $text); 

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
?>
