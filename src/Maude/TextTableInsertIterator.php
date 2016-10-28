<?php
namespace Maude;
use Iterator;

class TextTableInsertIterator extends AbstractMaudeLasikInsertIterator {

  private $mdr_report_key;
  private $text_report;

  const mdr_report_key = 0;
  const text_report = 4;

  public function __construct(\PDO $pdo_in) 
  {
      parent::__construct($pdo_in, "INSERT INTO textfoi(mdr_report_key, text_report) values (:mdr_report_key, :text_report)");
  }

  protected function bindParameters(\PDOStatement $insert_stmt)
  {
      // bind the parameters in each statement
      $insert_stmt->bindParam(':mdr_report_key', $this->mdr_report_key, \PDO::PARAM_INT);
        
      $insert_stmt->bindParam(':text_report', $this->text_report, \PDO::PARAM_STR);
  }

  protected function assignParameters(\Ds\Vector $vec) 
  {
    $this->mdr_report_key = intval($vec[TextTableInsertIterator::mdr_report_key]);
    $this->text_report = $vec[TextTableInsertIterator::text_report];
  }
}
?>
