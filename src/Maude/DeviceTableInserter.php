<?php
namespace Maude;

class DeviceTableInserter implements AbstractMaudeLasikIterator, \Iterator {

  private $pdo;

  private $mdr_report_key;
  private $device_product_code;

  private $rc;

  public function __construct(\PDO $pdo_in) 
  {
      parent::__construct($pdo_in, "INSERT INTO foi_device(mdr_report_key, device_product_code) values
	      (:mdr_report_key, :device_product_code )"); 
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

  public function valid() : bool
  {
     return true;
  }

  public function rewind() : bool
  {

  } 
  
  public function current() : \PDOStatement;
  
  public function key() : int;

}
