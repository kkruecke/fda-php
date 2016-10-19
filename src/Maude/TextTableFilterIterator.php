<?php
class TextTableFilterIterator {

     private $max_mdr_report_key_in_foitext;
     private $max_mdr_report_key_index = 0; // TODO: Is 0 correct?

     public function __construct(\PDO $pdo)
     {
       /*
        * Make make sure the prospective mdr_report_keys in the foitext files ( and its text) are not already in the foitext table. Since we know that the 
        * mdr_report_key is unique in foitext. Therefore simply query it for the max mdr_report_key. Any more recent mdr_report_keys
        * will be greater than prior, existing mdr report keys already in foitext.
        */ 

       $max_select_stmt = $pdo->query("SELECT MAX(mdr_report_key) from foitext"); 

       $this->max_mdr_report_key_in_foitext = (int) $max_select_stmt->fetch(\PDO::FETCH_COLUMN, 0); 

        $max_mdr_report_key = $pod->query("SELECT max(mdr_report_key) as max_mdr_report_key FROM foi_device");
     }

     protected function is_new_record(\Ds\Vector $vec) : bool
     {
         return ($vec[0] > $this->max_mdr_report_key_in_foitext) ? true : false;
     }

}
