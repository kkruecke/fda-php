#!/usr/bin/php
<?php
use Maude\Configuration as Configuration;

require_once("class_loader.php");

boot_strap();

function copy_if(\SpileFileObject $file_iter, \DatabaseInsertIterator $db_iter,  lambda/closure)
{
  foreach ($file_iter as $vec) {

     if (is_new_data($vec)) {

         $db_iter->insert();
     } 

     $db_iter->next();
  }
}

function copy(\SpileFileObject $file_iter, \DatabaseInsertIterator $db_iter,  lambda/closure)
{
  foreach ($file_iter as $vec) {


         $db_iter->insert();
     } 

     $db_iter->next();
  }
}


try {
    // TODO: Change Registry to use .xml fie and SimpleXML  

   $config = Configuration::getConfiguration('file_name');
   
   $db_handle = new \PDO("mysql:host=" . $config->database->host . ";dbname=" . $config->getDatabase()->dbname,
                         $config->getDatabase()->dbuser, $config->getDatabase()->dbpasswd);  
   
  $db_handle->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );  

  foreach($config.getFiles() => $file_name) {

    $className = "Maude\\" .  $file_handlers[$file_type]; 
        
    $databaseInsertIterator = new $className($file_name, $db_handle);

    $file_iterator = new SplFileObjectEx($file_name);
  
    $filter_iterator = new  "Maude\\" . $filter_iterator($file_iterator);
  
    copy($filter_iterator, $datatbaseInsertIterator, lamba_closure {} );

  }

  echo "\nupdateDatabase() complete\n"; // debug

  // TODO: Add code to insert new Maude tables data into medwatch_report table.

} catch (Exception $e) {

   $errors = "\nException Thrown in " . $e->getFile() . " at line " . $e->getLine() . "\n";
      
   $errors .= "Stack Trace as string:\n" . $e->getTraceAsString() . "\n";
          
   $errors .= "Error message is: " .   $e->getMessage() . "\n";
      
   echo $errors;

} // end try

