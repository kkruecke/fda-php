<?php
namespace Maude;
require_once("stdlib/algorithms.php");

class MdrTableFunctor implements MaudeFunctor {

     const index_mdr_report_key = 0; // This is the index in \Ds\Vector which contains all only the fields in a row of the mdrfoi.txt file that are specified by
                                     // <indecies></indecies> section.

     private  $mdr_report_keys;   // sorted \Ds\Vector
 
     public function __construct(\PDO $pdo)
     {
        // If the table is empty, then set device_max_mdr_report_key to -1.
        $cnt_stmt = $pdo->query("SELECT count(*) FROM devicefoi");

        $count = (int) $cnt_stmt->fetchColumn();

        $this->mdr_report_keys = new \Ds\Vector(); // default size of zero.
 
        if ($count != 0) {

           $this->mdr_report_keys->allocate($cnt);
                      
           $stmt = $pdo->query("SELECT DISTINCT mdr_report_key from devicefoi ORDER BY mdr_report_key ASC");

           foreach($stmt as $mdr_report_key) {

                $this->mdr_report_keys->push($mdr_report_key);
           }
        } 
     }
     
     public function __invoke(\Ds\Vector $vector) : bool
     {
         $mdr_report_key = (int) $vector[MdrTableFunctor::index_mdr_report_key];

         return binary_search(device_mdr_report_keys, $mdr_report_key);
     }
}
