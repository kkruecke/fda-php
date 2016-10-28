<?php
use Maude\Configuration,
Maude\ExistsInDeviceFunctor,
Maude\SplFileObjectExtended,
Maude\MaudeRegexIterator,
Maude\MaudeFilterIterator;
 
require_once("class_loader.php");

boot_strap();

try {

   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $pdo = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION ); 
   
   $pdo->beginTransaction();
    
   foreach($config->getFiles()->file as $file) {
       
      $spl_file_object_extended =  new SplFileObjectExtended($file['name']);

      $indecies = $config->getIndecies($file);

      $maudeFieldExtractor  = new MaudeRegexIterator($spl_file_object_extended, $indecies); 
      
      $tableFunctor = (string) $file['functor'];
      
      $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, new $tableFunctor($pdo));

      $dbIteratorName  = (string) $file['dbinsert_iter'];
            
      $dbIterator = new $dbIteratorName($pdo);
               
      foreach ($filterIterator as $vec) {
      
         $dbIterator->insert($vec);

         $cnt = $dbIterator->getInsertCount();

         if ( $cnt > 0 && ($cnt % 100 == 0)) {

            echo $dbIterator->getInsertCount() . " lines inserted using " . $dbIteratorName . "\n";
         }
      }
  }
  
  $pdo->commit();

// TODO: Add code to insert new Maude tables data into medwatch_report table.
include ("new-medwatch-update.php");
  update_medwatch_report()

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

