<?php
namespace Maude;

class TextTableFunctor  extends ExistsinDeviceTableFunctor {

/*
 * FOI TEXT files contains the following 6 fields:
   
    1. MDR Report Key 
    2. MDR Text Key  
    3. Text Type Code (D=B5, E=H3, N=H10 from mdr_text table)
    4. Patient Sequence Number (from mdr_text table) -- digit(s).
    5. Date Report (from mdr_text table)  -- it seems this can be empty, but in the current year file only.
    6. Text (B5, or H3 or H10 from mdr_text table) 

   Only five of these values have been extracted from the foitext.txt file into a \Ds\Vector by MaudeRegexIterator(the indecies of those five values are in
   the <indecies></indecies> section of config.xml.): 
    1. mdr report key
    2. text key
    3. text type code
    4. patient sequence number
    5. text (#6. above)
   
   This functor will only examine the mdr_report_key, the text_type_code and the patient_sequence_no.
 */
     const mdr_report_key = 0;
     const text_type_code = 2;
     const patient_sequence_no = 3;
           
     const TEXT_TYPE_CODE_REQD = 'D';
     const PATIENT_SEQ_NO_REQD = '1';

     //--private  $mdr_report_keys;       // sorted \Ds\Vector
     private  $prior_mdr_report_key;  // TODO: Set this value appropriately
 
     public function __construct(\PDO $pdo)
     {
           parent::__construct($pdo);
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
         $text_type_code = (string) $vector[TextTableFunctor::text_type_code];

         $patient_seq_no = (string) $vector[TextTableFunctor::patient_sequence_no];

         $must_be_true = ($text_type_code[0] == TextTableFunctor::TEXT_TYPE_CODE_REQD && ($patient_seq_no[0] == TextTableFunctor::PATIENT_SEQ_NO_REQD || empty($patient_seq_no)));  

         if (!$must_be_true) return false;

         $mdr_report_key =mdr_report_key intval($vector[TextTableFunctor::mdr_report_key]);

         if ($mdr_report_key == $this->prior_mdr_report_key) {

             return false;
         }
         
         if (parent::existsInDeviceTable($mdr_report_key)) {

                $this->prior_mdr_report_key = $mdr_report_key;
                return true;
 
         } else {

                return false;
         }
     } 
}
