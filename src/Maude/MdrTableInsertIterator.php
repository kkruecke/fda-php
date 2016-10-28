<?php
namespace Maude;
use Iterator;

class MdrTableInsertIterator extends AbstractMaudeLasikInsertIterator {

   private  $report_source_code;
   private  $mdr_report_key;
   private  $date_received;

   public function __construct(\PDO $pdo)
   {
       parent::__construct($pdo, "INSERT INTO mdrfoi(mdr_report_key, report_source_code, date_received) values (:mdr_report_key, :report_source_code, :date_received)");
   }

  // Called from within parent::__construct()
   public function bindParameters(\PDOStatement $insert_stmt)
   {
      // bind the parameters in each statement
      $insert_stmt->bindParam(':mdr_report_key', $this->mdr_report_key, \PDO::PARAM_INT);
        
      $insert_stmt->bindParam(':report_source_code', $this->report_source_code, \PDO::PARAM_STR);
      
      $insert_stmt->bindParam(':date_received', $this->date_received, \PDO::PARAM_STR);
   }

  protected function assignParameters(\Ds\Vector $vec) 
  {
    $this->mdr_report_key = intval($vec[0]);
    $this->report_source_code = (string) $vec[1];
    
    $date_array = explode('/', (string) $vec[2]);  
    
    $this->date_received = $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1];
  }
}
?>
