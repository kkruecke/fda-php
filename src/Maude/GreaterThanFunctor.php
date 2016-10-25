<?php
namespace Maude;
//require_once("../stdlib/algorithms.php");

class GreaterThanFunctor implements Functor {

     private $device_max_mdr_report_key;
 
     public function __construct(\PDO $pdo)
     {
        // If the table is empty, then set device_max_mdr_report_key to -1.
        $cnt_stmt = $pdo->query("SELECT count(*) FROM devicefoi");

        $count = (int) $cnt_stmt->fetchColumn();
 
        if ($count != 0) {

           $max_stmt = $pdo->query("SELECT max(mdr_report_key) as max_mdr_report_key FROM devicefoi");

           $this->device_max_mdr_report_key = (int) $max_stmt->fetchColumn();

        } else { 

           $this->device_max_mdr_report_key = -1;
        }
     }
     
     public function __invoke(int $mdr_report_key) : bool
     {
         return $mdr_report_key > $this->device_max_mdr_report_key;
     }
}
