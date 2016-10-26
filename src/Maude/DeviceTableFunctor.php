<?php
namespace Maude;

class DeviceTableFunctor implements MaudeFunctor {

  const index_mdr_report_key =  0;
  const index_seq_no = 1;
  const index_prod_code =  2;

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
     
     public function __invoke(\Ds\Vector $vector) : bool
     {
         // Is it a LASIK record?
         $prod_code = (string) $vector[DeviceTableFunctor::index_prod_code];
         
         if ($prod_code != "LZS" && $prod_code != "HNO") {
             
              return false;
         }
         
         // Is the sequence number 1.0?
         $seq_no = (string) $vector[DeviceTableFunctor::index_seq_no];
 
         if ($seq_no != "1.0") {

             return false;
         }

         // Is it a new mdr_report_key, greater than the prior max value in the table before we ran this code?
         $mdr_report_key = (int) $vector[DeviceTableFunctor::index_mdr_report_key];

         return ($mdr_report_key > $this->device_max_mdr_report_key) ? true : false;
     }
}
