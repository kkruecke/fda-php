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

   return $text; 
}
?>
