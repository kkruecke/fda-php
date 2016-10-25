<?php
use Maude\DeviceTableInsertIterator as DeviceTableInsertIterator,
Maude\Configuration as Configuration,
Maude\GreaterThanFunctor as GreaterThanFunctor,
Maude\FilterIterator as MaudeFilterIterator;



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

   $x = new GreaterThanFunctor($pdo);
    
   foreach($config->getFiles()->file as $file) {
       
       $dbiter = (string) $file['dbinsert_iter'];
       
      $a = new \Maude\DeviceTableInsertIterator($pdo);    
      
      $functor = new $dbiter();
       
      $functorName = (string) $file['functor'];
      
      $functor = new $functorName;
      
      $functor2 = new $functorName($pdo);
      
      
      $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, $functor);
  
  }

  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

