<?php
namespace Maude;
require_once("stdlib/algorithms.php");

class GreaterThanFunctor implements Functor {

     private $device_max_mdr_report_key;
 
     public function construct(\PDO $pdo)
     {
        // If the table is empty, then set device_max_mdr_report_key to -1.
        $cnt_stmt = $pdo->query("SELECT count(*) FROM foi_device");

        $count = (int) $cnt_stmt->fetchColumn();
 
        if ($count != 0) {

           $max_stmt = $pdo->query("SELECT max(mdr_report_key) as max_mdr_report_key FROM foi_device ORDER BY ASC");

           $this->device_max_mdr_report_key = $max_stmt->fetchColumn();

        } else { 

           $this->device_max_mdr_report_key = -1;
        }
     }

     protected function is_new_record(int $mdr_report_key) : bool
     {
         return $mdr_report_key_index > $this->device_max_mdr_report_key;
     }
}
