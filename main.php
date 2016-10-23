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
 MaudeLasikFunctor as MaudeLasikFunctor}; 

require_once("class_loader.php");

boot_strap();

function getIndecies(\SimpleXMLElement $file) : \Ds\Vector 
{
   $vec = new \Ds\Vector;

   $indecies =  $file->indecies;
   
   foreach($indecies->index as $index) {

      $vec->push($index);
   }

   return $vec;
}

try {

   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $db_handle = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $db_handle->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );  
   
   foreach($config->getFiles()->file as $file) {

      $spl_file_object_extended =  new SplFileObjectExtended($file['name']);

      $vec = getIndecies($file);

      $maudeFieldExtractor  = new MaudeRegexIterator($spl_file_object_extended, $file['indecies']); 

      $filterIterator = new MaudeFilterIterator($maudeFieldExtractor, new MaudeLasikFunctor($pdo));
  
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

