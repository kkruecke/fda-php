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
 
  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

