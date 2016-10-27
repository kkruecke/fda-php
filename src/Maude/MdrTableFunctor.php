<?php
namespace Maude;

//class MdrTableFunctor implements MaudeFunctor {
class MdrTableFunctor extends ExistsinDeviceTableFunctor {

     const index_mdr_report_key = 0; // This is the index in \Ds\Vector which contains all only the fields in a row of the mdrfoi.txt file that are specified by
                                     // <indecies></indecies> section.

     public function __construct(\PDO $pdo)
     {
        parent::__construct($pdo);
     }
     
     public function __invoke(\Ds\Vector $vector) : bool
     {
         $mdr_report_key = (int) $vector[MdrTableFunctor::index_mdr_report_key];

	 return parent::existsInDeviceTable($mdr_report_key);
     }
}
