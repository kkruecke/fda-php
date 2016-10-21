<?php
use Maude\{Configuration as Configuration,
 SplFileObjectExtended as SplFileObjectExtended,
 DeviceTableFilterIterator as  DeviceTableFilterIterator,
 DeviceTableInsertIterator as DeviceTableInsertIterator,
 MdrTableFilterIterator as  MdrTableFilterIterator,
 MdrTableInsertIterator as MdrTableInsertIteratpr, 
 TextTableFilterIterator as  TextTableFilterIterator,
 TextTableInsertIterator as TextTableInsertIterator}; 

require_once("class_loader.php");

boot_strap();

try {

   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $db_handle = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $db_handle->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );  
   
   foreach($config->getFiles()->file as $file) {

    /*   
      $splFileObj = new SplFileObjectExtended($file['name']); 
  
      $filter_iterator = new $file['filter_iter']($pdo, $splFileObj); 
          
      $db_iter = new $file['dbinsert_iter'];    
      
      // Copy filtered file results to database using database iterator.
      foreach ($filterIter as $vector) {
  
          $db_iter->insert($vector);
      }
    */

      $spl_file_object_extended =  new SplFileObjectExtended($file['name']);
      
      $regexIterator = RegexIterator($spl_file_object_extended, "[^|]*(\||$)" , RegexIterator::ALL_MATCHES);

      $extractorIterator = MaudeFilterIterator($regexIterator, $functor, $indecies);
  
      foreach ($file_iterator => $vec) {
      
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

