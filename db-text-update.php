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

   $select_str = "SELECT id, text_report as text from medwatch_report"; 

   $update = "UPDATE medwatch_report set text_report=:text WHERE id=:id"; 

   $selectStmt = $pdo->query($select_str);

   $selectStmt->setfetchMode(PDO::FETCH_NUM);

   $preUpdate = $pdo->prepare($update);   

   $id = -1;  // primary key
   $text;     // report text

   $preUpdate->bindParam(':text', $text, PDO::PARAM_STR);

   $preUpdate->bindParam(':id', $id, PDO::PARAM_INT);

   $counter = 0;
      
   while($results = $selectStmt->fetch()) {
                
        $id = $results[0];
 
        $text = fixTitles($results[1]); 

        // update the current text using the database write iterator.
        $b = $preUpdate->execute();
        
        if ($b == false) {
            
            throw new \Exception("preUpdte->execute() returned false.\n");
        }

        if ((++$counter % 100) == 0) {

           echo $counter . " records have been processed.\n";
        }
   }
} catch(\Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

}
