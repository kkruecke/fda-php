<?php
namespace Maude;

class TextTableInserter implements DatabaseInsertIterator, \Iterator {

  private $mdr_report_key;
  private $text_report;

  public function __construct(\PDO $pdo_in) 
  {
      parent::__construct($pdo_in, "INSERT INTO foitext(mdr_report_key, text_report) values (:mdr_report_key, :text_report)");
       
  }

  protected function bindParameters(\PDOStatement $insert_stmt)
  {
      // bind the parameters in each statement
      $insert_stmt->bindParam(':mdr_report_key', $this->mdr_report_key, \PDO::PARAM_INT);
        
      $insert_stmt->bindParam(':device_product_code', $this->device_product_code, \PDO::PARAM_STR);
  }

  protected function assignParameters(\Ds\Vector $vec) : void
  {
    $this->mdr_report_key = $vec[0];
    $this->device_report_code = $vec[1];
  }
 
  // TODO: What to do about these methods that are abstract, right? 
  public function current() : \PDOStatement;
  
  public function key() : int;
}
?>
