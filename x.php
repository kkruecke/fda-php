<?php
use Maude\Configuration,
Maude\ExistsInDeviceFunctor,
Maude\SplFileObjectExtended,
Maude\MaudeRegexIterator,
Maude\MaudeFilterIterator,
Maude\MedwatchTable;
 
require_once("class_loader.php");

boot_strap();


   $config = Configuration::getConfiguration('config.xml');
   
   $db = $config->getDatabase();
   
   $pdo = new \PDO("mysql:host=" . $db->host . ";dbname=" . $db->name,
                         $db->user, $db->password);  
   
   $pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION ); 
 
  $medwatch_report = new MedwatchTable($pdo);
  
  $medwatch_report->insertMaudeData();
  
  echo "The number of new rows inserted into medwatch_report = " . $medwatch_report->getInsertCnt() . "\n";  


