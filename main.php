<?php
use Maude\Configuration,
Maude\ExistsInDeviceFunctor,
Maude\SplFileObjectExtended,
Maude\DeviceTableFilterIterator,
Maude\DeviceTableInsertIterator,
Maude\MdrTableFilterIterator,
Maude\MdrTableInsertIterator,
Maude\TextTableFilterIterator,
Maude\TextTableInsertIterator,
Maude\MaudeRegexIterator,
Maude\MaudeFilterIterator;
 
require_once("class_loader.php");

boot_strap();

function getFileIndecies2(\SimpleXMLElement $file) : \Ds\Map 
{
   $map = new \Ds\Map;
   $indecies =  $file->indecies;
   
   foreach($indecies->index as $index) {

      $field_name = (string) $index['field_name']; 

      $map[$field_name] =  $index;
   }
   return $map;
}


try {

   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $pdo = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION ); 
    
   foreach($config->getFiles()->file as $file) {
       
      $spl_file_object_extended =  new SplFileObjectExtended($file['name']);

      $indecies = $config->getIndecies($file);

      $maudeFieldExtractor  = new MaudeRegexIterator($spl_file_object_extended, $indecies); 
      
      $tableFunctor = (string) $file['functor'];
      
      $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, new $tableFunctor($pdo));

      $dbIteratorName  = (string) $file['dbinsert_iter'];
            
      $dbIterator = new $dbIteratorName($pdo);

      $cnt = 0; 
  
      foreach ($filterIterator as $vec) {

         $dbIterator->insert($vec);
       
         if ((++$cnt % 100) == 0) {

            echo $cnt . " lines inserted using " . $dbIteratorName . "\n";
         } 
      }
  }

  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

