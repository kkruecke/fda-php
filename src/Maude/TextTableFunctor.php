<?php
namespace Maude;
require_once("stdlib/algorithms.php");

class TextTableFunctor implements MaudeFunctor {

/*
 * FOI TEXT files contains the following 6 fields:
   
    1. MDR Report Key 
    2. MDR Text Key  
    3. Text Type Code (D=B5, E=H3, N=H10 from mdr_text table)
    4. Patient Sequence Number (from mdr_text table) -- digit(s).
    5. Date Report (from mdr_text table)  -- it seems this can be empty, but in the current year file only.
    6. Text (B5, or H3 or H10 from mdr_text table) 

   We only save the MDR Report Key and the Text
 */
     const index_mdr_report_key = 0;
     const index_text_type_code = 2:
     const index_patient_seq_no = 3:

     const TEXT_TYPE_CODE = 'D';
     const PATIENT_SEQ_NO = '1';

     private  $mdr_report_keys;       // sorted \Ds\Vector
     private  $prior_mdr_report_key;  // TODO: Set this value appropriately
     private  $mdr_report_keys;       // sorted \Ds\Vector
 
     public function __construct(\PDO $pdo)
     {
        $this->prior_mdr_report)key = -1;
 
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
   /* 
     We only want rows where text_type_code == 'D' and the sequence number is empty or 1. NOTE: This does guarantee that the mdr_report_key will only occur
     once. 
    
     There can be instances where the mdr_report_key occurs more than once when the text_type is 'D' and the sequence number is 1( but we only save the 
     first instance)
    * 
    * TODO: BUG
    *  
    * However, I discovered this is not the whole story. There can be multiple instances of an mdr report key where the Text Type Code is D (or N) and the
    * sequence number is 1. So the tuple (mdr_report_key, D, 1) and (mdr_report_key, N, 1) is not a key. It can occur more than once.
    * 
    * In these instances, the 2nd column, MDR Text Key, appears to be different, however. 
    * Determine if the mdr text key is unique per row, or if the mdr report key is also need, so that pair (mdr report key, mdr text report) is a key.
    
     The third colum is the Text Type Code. It indicates the section that contains the text.

         Text Type Code  | Section | Description
       -----------------------------------------
      1.       D         |  B5     |
      2.       E         |  H3     | Manufacturer's section?
      3.       N         |  H10    | Additional Manufacturer's narrative
    */
         $text_type_code = (string) $vector[TextTableFunctor::index_text_type_code];

         $patient_seq_no = (string) $vector[TextTableFunctor::index_sequence_no];

         $must_be_true = (text_type_code[0] == TextTableFunctor::TEXT_TYPE_CODE && ($patient_seq_no[0] == TextTableFunctor::PATIENT_SEQ_NO || empty($patient_seq_no)));  

         if (!$must_be_true) return false;

         $mdr_report_key = (int) $vector[TextTableFunctor::index_mdr_report_key];

         if ($mdr_report_key == $this->prior_mdr_report_key) {

             return false;
         }

         // Check that the mdr_report_key exists in devicefoi, i.e. that it is a lasik record.
         if ( binary_search($this->mdr_report_keys, $mdr_report_key) {

                $this->prior_mdr_report_key = $mdr_report_key;
                return true;
 
         } else {

                return false;
         }
     } 
}
