<?php
namespace Maude;
use Iterator;

class TextTableInsertIterator extends AbstractMaudeLasikInsertIterator {

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
        
      $insert_stmt->bindParam(':text_report', $this->device_product_code, \PDO::PARAM_STR);
  }

  protected function assignParameters(\Ds\Vector $vec) 
  {
    $this->mdr_report_key = intval($vec[0]);
    $this->text_report = $vec[1];
  }
}
?>
