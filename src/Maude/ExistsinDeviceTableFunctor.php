<?php
namespace Maude;
require_once("stdlib/algorithms.php");

class ExistsinDeviceTableFunctor implements Functor {

     \Ds\Vector $sorted_vector;

     public function __construct(\PDO $pdo)
     {
        $count_stmt = $pdo->query("SELECT count(*) FROM devicefoi");

        $size = $count_stmt->fetchColumn(); 

        $this->sorted_vector = new \Ds\Vector();
        $this->sorted_vector->allocate($size);

        $max_stmt = $pdo->query("SELECT mdr_report_key as max_mdr_report_key FROM devicefoi ORDER BY ASC");
        
        while ($max_stmt => $key) {

             $this->sorted_vector->push($key);
        }
     }

     public function __invoke(int $mdr_report_key) : bool
     {
         return binary_search($mdr_report_key_index, $this->sorted_vector);
     }
}
