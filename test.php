<?php
use Maude\Configuration,
Maude\ExistsInDeviceFunctor,
Maude\SplFileObjectExtended,
Maude\DeviceTableInsertIterator,
Maude\MdrTableInsertIterator,
Maude\TextTableInsertIterator,
Maude\MaudeRegexIterator,
Maude\MaudeFilterIterator,
Maude\MdrTableFunctor,
Maude\DeviceTableFunctor,
Maude\TextTableFunctor;

require_once("class_loader.php");
require_once("src/stdlib/algorithms.php");

boot_strap();

try {

   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $pdo = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION ); 
           
   $spl_file_object_extended =  new SplFileObjectExtended("data/mdrfoi.txt");

   $indecies =new \Ds\Vector([0, 3, 7]);

   $maudeFieldExtractor  = new MaudeRegexIterator($spl_file_object_extended, $indecies); 
      
   $tableFunctor = new MdrTableFunctor($pdo);
      
   $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, $tableFunctor);

   $sorted = new \Ds\Vector([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);  

   for($i = 20; $i > 0; --$i) {

       $b = binary_search($sorted, $i);
       $msg = $b ? "true" : "false";
       echo "binary_search($sorted, $i) = " . $msg . "\n";
      
   }
 
  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

