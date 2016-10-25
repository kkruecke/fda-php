<?php
use Maude\Configuration,
Maude\ExistsInDeviceFunctor,
Maude\GreaterThanFunctor as XYZ,
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

//$test = new Maude\GreaterThanFunctor();

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
   
   $y = "XYZ";
   
   $y2 = new $y($pdo);
    
   foreach($config->getFiles()->file as $file) {
       
  
  }

  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

