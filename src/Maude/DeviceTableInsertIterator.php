<?php
namespace Maude;
use Iterator;

class DeviceTableInsertIterator extends AbstractMaudeLasikInsertIterator {

  private $mdr_report_key;
  private $device_product_code;
  private $device_sequence_number;

  private $rc;

  public function __construct(\PDO $pdo_in) 
  {
      parent::__construct($pdo_in, "INSERT INTO devicefoi(mdr_report_key, device_product_code) values
	      (:mdr_report_key, :device_product_code )"); 
  }

  protected function bindParameters(\PDOStatement $insert_stmt)
  {
      // bind the parameters in each statement
      $insert_stmt->bindParam(':mdr_report_key', $this->mdr_report_key, \PDO::PARAM_INT);
        
      $insert_stmt->bindParam(':device_product_code', $this->device_product_code, \PDO::PARAM_STR);
      
      return;
  }

  protected function assignParameters(\Ds\Vector $vec) 
  {
    $this->mdr_report_key = (int) $vec[0];
    $this->device_product_code = (string) $vec[2];

    return;
  }
  // TODO: This is just an idea of logging unsuccessful inserts.
  public function valid() : bool
  {
      $bool = parent::valid();

      if ($bool == false) {

          // TODO: Log error. 'mdr_report_key... from table...could not be inserted.
      }   

      return $bool; 
}
