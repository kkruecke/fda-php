<?php
namespace Maude;

//class MdrTableFunctor implements MaudeFunctor {
class MdrTableFunctor extends ExistsinDeviceTableFunctor {

     const mdr_report_key = 0; // This is the index in \Ds\Vector which contains all only the fields in a row of the mdrfoi.txt file that are specified by
                                     // <indecies></indecies> section.
     
     private $prior_mdr_report_key; //debug

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
