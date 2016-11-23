<?php

require_once("class_loader.php");

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
 
boot_strap();

try {
   
   $pdo = new \PDO("mysql:host=localhost;dbname=medwatch_backup", "kurt", "kk0457");  
   
   $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION ); 
   
   $pdo->beginTransaction();

   $select = "SELECT id, :text_report as text from medwatch_report"; 

   $update = "UPDATE medwatch_report VALUES(?,?) WHERE id=:id"; 

   $preSelect = $pdo->prepare($select);   

   $preUpdate = $pdo->prepare($update);   

   $id = -1;  // primary key
   $text;     // report text

   $preSelect->bindParameters( );
   $preSelect->fetchMode();

   $preUpdate->bindParameters( );
   $preSelect->fetchMode();

   foreach ($preSelect as $results) {

        $id = $results['id'];
 
        $text = fixTitles($results['text']); 

        // update the current text using the database write iterator.
        $preUpdate->execute();
   }
}
