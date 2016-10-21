<?php
namespace Maude;
class DeviceFunctor extends Functor {

     private $max_mdr_report_key;
     private $max_mdr_report_key_index = 0; // TODO: Is 0 correct?

     public function __construct(\PDO $pdo) 
     {
        parent::__construct($iter);

        $max_mdr_report_key = $pod->query("SELECT max(mdr_report_key) as max_mdr_report_key FROM foi_device");

        $row = $max_mdr_report_key->fetch();

        $this->max_mdr_report_key = $row['max_mdr_report_key']; 
     }

     protected function __invoke(int $mdr_report_key $vec) : bool
     {
         return //$vec[$this->mdr_report_key_index] > $max_mdr_report_key ? true : false; 
     }

}
