<?php
use Maude\Configuration,
Maude\ExistsInDeviceFunctor,
Maude\SplFileObjectExtended,
Maude\MaudeRegexIterator,
Maude\MaudeFilterIterator,
Maude\MedwatchTable;
 
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
      
      // 1. Compose a file filter iterators to read input file.
      $spl_file_object_extended =  new SplFileObjectExtended($file['name']);

      $indecies = $config->getIndecies($file);
      
      // Filter SplFileObjectExtended results with a regular expression
      $maudeFieldExtractor  = new MaudeRegexIterator($spl_file_object_extended, $indecies); 
     
      // Filter further the results with the custom table functor that decides if the record is already is in the DB. 
      $tableFunctor = (string) $file['functor'];
      
      $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, new $tableFunctor($pdo));
      
      // 2. Create the output database insert iterator
       
      $dbIteratorName  = (string) $file['dbinsert_iter'];
            
      $dbIterator = new $dbIteratorName($pdo);
               
      foreach ($filterIterator as $vec) {
      
         $dbIterator->write($vec);

         $cnt = $dbIterator->getInsertCount();

         if ( $cnt > 0 && ($cnt % 100 == 0)) {

            echo $dbIterator->getInsertCount() . " lines inserted using " . $dbIteratorName . "\n";
         }
      }
  }

  echo "Commiting database changes (if any).\n";
  $pdo->commit();
  
  $medwatch_report = new MedwatchTable($pdo);

  $medwatch_report->insertMaudeData();

  echo "The number of new rows inserted into medwatch_report = " . $medwatch_report->getInsertCnt() . "\n";  
 
} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

