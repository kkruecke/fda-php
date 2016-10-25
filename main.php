<?php
use Maude\{Configuration as Configuration,
 SplFileObjectExtended as SplFileObjectExtended,
 DeviceTableFilterIterator as  DeviceTableFilterIterator,
 DeviceTableInsertIterator as DeviceTableInsertIterator,
 MdrTableFilterIterator as  MdrTableFilterIterator,
 MdrTableInsertIterator as MdrTableInsertIteratpr, 
 TextTableFilterIterator as  TextTableFilterIterator,
 TextTableInsertIterator as TextTableInsertIterator,
 MaudeRegexIterator as MaudeRegexIterator, 
 MaudeFilterIterator as MaudeFilterIterator,
 GreaterThanFunctor as GreaterThanFunctor,  
 ExistsInDeviceFunctor as ExistsInDeviceFunctor}; 

require_once("class_loader.php");

boot_strap();


function getFileIndecies(\SimpleXMLElement $file) : \Ds\Vector 
{
   $vec = new \Ds\Vector;
   $indecies =  $file->indecies;
   
   foreach($indecies->index as $index) {
       
      $vec->push((int) $index);
   }
   return $vec;
}

try {

   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $pdo = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION ); 
    
   foreach($config->getFiles()->file as $file) {
       
      $spl_file_object_extended =  new SplFileObjectExtended($file['name']);

      $indecies = getFileIndecies($file);

      $maudeFieldExtractor  = new MaudeRegexIterator($spl_file_object_extended, $indecies); 
      
      $functorName = (string) $file['functor'];
      
      $dbIteratorName  = (string) $file['dbinsert_iter'];;
          
      $functor = new $functorName($pdo);
      
      $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, $functor);
            
      $dbIterator = new $dbIteratorName;
  
      foreach ($filterIterator as $vec) {
      
         $dbIterator->insert($vec);
      }
  }

  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

