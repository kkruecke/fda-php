<?php

require_once("stdlib/algorithms.php");

trait ExistsinDeviceTableTrait {

     private $max_mdr_report_key_in_foitext;
     private $max_mdr_report_key_index = 0; // TODO: Is 0 correct?

     \Ds\Vector $sorted_vec_dev_mdr_report_keys;

     public function construct(\PDO $pdo)
     {
        $max_stmt = $pdo->query("SELECT mdr_report_key as max_mdr_report_key FROM foi_device ORDER BY ASC");

        while ($max_stmt => $key) {

             $sorted_vec_dev_mdr_report_keys->push($key);
        }
     }

     protected function is_new_record(int $mdr_report_key) : bool
     {
         return binary_search($mdr_report_key_index, $this->sorted_vec_dev_mdr_report_keys);
     }
}
