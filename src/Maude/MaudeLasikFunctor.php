<?php
namespace Maude;
use \Ds\Vector as Vector;
require_once("../stdlib/algorithms.php");

class MaudeFunctor {

     private $max_mdr_report_key_in_foitext;
     private $max_mdr_report_key_index; 

     private $sorted_vec_dev_mdr_report_keys;

     public function construct(\PDO $pdo)
     {
        $max_stmt = $pdo->query("SELECT mdr_report_key as max_mdr_report_key FROM foi_device ORDER BY ASC");

        $this->sorted_vec_dev_mdr_report_keys = new Vector();

        foreach ($max_stmt as $key) {

             $sorted_vec_dev_mdr_report_keys->push($key);
        }
     }

     protected function is_new_record(int $mdr_report_key) : bool
     {
         return binary_search($mdr_report_key_index, $this->sorted_vec_dev_mdr_report_keys);
     }

     public function __invoke(int $mdr_report_key) : bool
     {
         return is_new_record($mdr_report_key);   
     }
}
