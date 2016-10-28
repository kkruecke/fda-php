<?php
namespace Maude;

class MdrTableFunctor extends ExistsinDeviceTableFunctor {

     const mdr_report_key = 0; // 0 is the index in \Ds\Vector that contains the mdr report key     

     private $prior_mdr_report_key; // TODO: Is this needed. Confer with C++ code.

     public function __construct(\PDO $pdo)
     {
        $this->prior_mdr_report_key = -1; 
        parent::__construct($pdo);
     }
     
     public function __invoke(\Ds\Vector $vector) : bool
     {
         $mdr_report_key = intval($vector[MdrTableFunctor::mdr_report_key]);
         
         if ($mdr_report_key == $this->prior_mdr_report_key)  { //debug
             
             echo "Mdr Functor found prior mdr report key\n";
         }
         
	 $bRc = parent::existsInDeviceTable($mdr_report_key);
         
         if ($bRc) { // debug
             
             $this->prior_mdr_report_key = $mdr_report_key;
         }
         
         return $bRc;
     }
}
