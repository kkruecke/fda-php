<?php
use Maude\{Configuration as Configuration, SplFileObjectExtended as SplFileObjectExtended, DeviceTableFilterIterator as  DeviceTableFilterIterator,
DeviceTableInsertIterator as DeviceTableInsertIterator, MdrTableFilterIterator as  MdrTableFilterIterator, MdrTableInsertIterator as MdrTableInsertIteratpr, 
TextTableFilterIterator as  TextTableFilterIterator, TextTableInsertIterator as TextTableInsertIterator}; 

require_once("class_loader.php");

boot_strap();

try {

   $config = Configuration::getConfiguration('config.temp.xml');
   
   $db = $config->getDatabase();
   
   var_dump($db);
   
   $db_handle = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
  $db_handle->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );  
  
  $files = $config->getFiles();
  
  foreach($files as $file) {
      
    // TODO: Fingure out how SimeplXMLElement works esp. for properties.  
    $file_iterator = new SplFileObjectExtended($file["name"]); // bug

    $filter_iterator = new $file["filter_iter"](new $file["dbinsert_iter"]($pdo)); // bug
    
    

    // Copy filtered file results to database
    foreach ($filterIter as $vector) {

       $db_iter->insert($vector);
    }
  }

  echo "\nupdateDatabase() complete\n"; // debug

  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

